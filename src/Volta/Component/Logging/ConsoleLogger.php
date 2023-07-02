<?php
/*
 * This file is part of the Volta package.
 *
 * (c) Rob Demmenie <rob@volta-framework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Volta\Component\Logging;

use DateTime;
use Stringable;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * The Console logger will send the log entries to the console if available. This means if STDOUT is available of
 * when we are running the PHP build in webserver. In the latter case we send the log entry to the error_log which
 * is printed to the console. In all other cases the entry is ignored
 */
class ConsoleLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * The log entries are made colorfully before send to the console.
     *
     * @param string $level See the class LogLevels
     * @param Stringable|string $message
     * @param array $context
     * @return void
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $formattedMessage = match (strtolower($level)) {
            LogLevel::EMERGENCY => "\e[93m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[33m $message \e[0m",
            LogLevel::ALERT => "\e[93m" . str_pad(strtoupper($level), 10) . "\e[33m $message \e[0m",
            LogLevel::CRITICAL => "\e[93m\e[4m" . str_pad(strtoupper($level), 10) . "\e[0m\e[33m $message \e[0m",
            LogLevel::ERROR => "\e[91m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[31m $message \e[0m",
            LogLevel::WARNING => "\e[95m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[35m $message \e[0m",
            LogLevel::NOTICE => "\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m $message",
            LogLevel::DEBUG => "\e[92m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[32m $message \e[0m",
            LogLevel::INFO => "\e[94m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[34m $message \e[0m",
            default => str_pad(strtoupper($level), 10) . ' ' . $message,
        };

        $formatContext = "\e[3m\e[90m context: " . print_r($context, true) . "\e[0m";
        if(defined('STDOUT')) {
            // if we are on the command line the constant STDOUT is defined
            // but a timestamp is not provided as this is done with an entry adding
            // to the error log. Hence, add the timestamp

            /**
             * @see https://www.php.net/manual/en/datetime.format.php
             */
            $date = new DateTime();
            $timestamp = $date->format('Y-m-d h:i:s.u' );
            fwrite(STDOUT, sprintf("\e[37m[%s]\e[0m %s\n",  $timestamp, $formattedMessage));

            if(count($context)) {
                fwrite(STDOUT,  $formatContext . "\n");
            }

        } elseif(php_sapi_name() === "cli-server") {
            // if not on the command line but in cli modes we add to the error log and
            // this will be printed to the console
            error_log($formattedMessage);
            if(count($context)) {
                error_log("\n" . $formatContext . "\n");
            }
        }
        else{
            // we send the log entry to dev null  ...
            //echo str_pad(strtoupper($level), 10) . ' ' . $message . "\n";
        }

    }

}