<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class MyConsoleLogger implements LoggerInterface
{
    use LoggerTrait;


    public function log($level, Stringable|string $message, array $context = []): void
    {
        // The constant STDOUT is available when the script is started from the command line and contains
        // a stream resource to the terminal
        if (defined('STDOUT')) {

            // create the timestamp
            $date = new DateTime();
            $timestamp = $date->format('Y-m-d h:i:s.u' );

            // convert array to string, add some formatting as well
            $contextAsString = (count($context)) ? "\n\t" . json_encode($context) : '';

            // Build the log entry for the terminal
            $logEntry = sprintf("[%s]\t%s\t%s %s", $timestamp, $level, $message, $contextAsString);
            fwrite(STDOUT, $logEntry);

        } else {

            // convert array to string, add some formatting as well
            $contextAsString = (count($context)) ? "\t" . json_encode($context) : '';

            // Build the log entry for the error log, in this case the error_log function will add a timestamp.
            $logEntry = sprintf("\t%s\t%s %s", $level, $message, $contextAsString);
            error_log($logEntry);
        }
    }
}


$log = new MyConsoleLogger();
$log->info('Log created');

echo "\nHallo world\n\n";
