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
use Psr\Log\InvalidArgumentException;
use Stringable;

use Volta\Component\Logging\EnumLogLevels as LogLevel;

/**
 * The Console logger will send the log entries to the console if available. This means if STDOUT is available of
 * when we are running the PHP build in webserver. In the latter case, we send the log entry to the error_log which
 * is printed to the console. In all other cases, the entry is ignored
 */
class ConsoleLogger extends BaseLogger
{

    public function __construct(array $levels = [])
    {
        $this->setLevels($levels);
    }

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
        if (!$this->hasLevel($level)) return;

        $formattedMessage = match (strtolower($level)) {
            LogLevel::EMERGENCY->value => "\e[93m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[33m $message \e[0m",
            LogLevel::ALERT->value => "\e[93m" . str_pad(strtoupper($level), 10) . "\e[33m $message \e[0m",
            LogLevel::CRITICAL->value => "\e[93m\e[4m" . str_pad(strtoupper($level), 10) . "\e[0m\e[33m $message \e[0m",
            LogLevel::ERROR->value => "\e[91m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[31m $message \e[0m",
            LogLevel::WARNING->value => "\e[95m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[35m $message \e[0m",
            LogLevel::NOTICE->value => "\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m $message",
            LogLevel::DEBUG->value => "\e[92m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[32m $message \e[0m",
            LogLevel::INFO->value => "\e[94m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[34m $message \e[0m",
            LogLevel::SQL->value => "\e[95m\e[1m" . str_pad(strtoupper($level), 10) . "\e[0m\e[34m $message \e[0m",
            default => str_pad(strtoupper($level), 10) . ' ' . $message,
        };

        $formatContext = "\e[3m\e[90m context: " . print_r($context, true) . "\e[0m";
        if(defined('STDOUT')) {
            /*
             * If we are on the command line, the constant STDOUT is defined
             * but a timestamp is not provided as this is done with an entry adding
             * to the error log.
             * Therefore, add the timestamp manually.
             *
             * @see https://www.php.net/manual/en/datetime.format.php
             */
            $date = new DateTime();
            $timestamp = $date->format('Y-m-d h:i:s.u' );
            fwrite(STDOUT, sprintf("\e[37m[%s]\e[0m %s\n",  $timestamp, $formattedMessage));

            if(count($context)) {
                fwrite(STDOUT,  $formatContext . "\n");
            }

        } elseif(php_sapi_name() === "cli-server") {
            /*
             * If not on the command line but in cli modes we add to the error log and
             * this will be printed to the console
             */
            error_log($formattedMessage);
            if(count($context)) {
                error_log("\n" . $formatContext . "\n");
            }
        }
        /* else{ // send the log entry to dev-null ... } */

    }

}