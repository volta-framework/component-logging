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

require_once __DIR__ . '/../vendor/autoload.php';

/*
 * Sent plain text in case of executing this script in the browser.
 */
@header('Content-Type: text/plain');

/*
 * Examples of the loggers available in this component.
 * This script can be run in the console or in the browser with the PHP build in server:
 *
 * ~$ php -S localhost:9090 index.php
 */
try {

    /*
     * create an array of available loggers
     */
    $logs = [
        new Psr\Log\NullLogger(),
        new Volta\Component\Logging\ConsoleLogger(),
        new Volta\Component\Logging\PassThroughLogger(function (mixed $level, string $message, array $context) {
            echo sprintf( date('Y-m-d H:m:s', time()) ." - (pass through) %s - %s \n", $level, $message);
        }),
        new Volta\Component\Logging\FileLogger(__DIR__ . '/../__log/example.log')
    ];

    /*
     * and add entries for each level
     */
    foreach($logs as $log) {
        echo "\n", get_class($log), ":\n";
        $log->alert('This is an alert entry');
        $log->critical('This is a critical entry');
        $log->debug('This is a debug entry');
        $log->emergency('This is an emergency entry');
        $log->error('This is an error entry');
        $log->info('This is an info entry');
        $log->notice('This is a notice entry');
        $log->warning('This is a warning entry');
        $log->log('CUSTOM', 'This is a custom entry');
        unset($log);
    }
    unset($logs); // calls the destruct on the file logger and releases the file resource

    /*
     * Show the content of the log file
     */
    echo "\n", file_get_contents(__DIR__ . '/../__log/example.log');

/*
 * Catch Exceptions
 */
} catch (\Volta\Component\Logging\Exception $e) {
    print_r($e);
}
