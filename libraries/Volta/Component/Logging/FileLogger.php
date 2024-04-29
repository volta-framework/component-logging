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

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * The File logger will append the log entries to a file. The file is set when the Log is instantiated. An exception is
 * thrown when the file is invalid.
 */
class FileLogger extends BaseLogger
{

    private mixed $_fileHandler;

    /**
     * @param string $filePath
     * @param bool $create
     * @throws Exception
     */
    public function __construct(string $filePath, bool $create = true)
    {
        $dir = dirname($filePath);
        $file = basename($filePath);

        if($create) {
           if (!is_dir($dir)) mkdir($dir,0777, true);
           if (!is_file($dir . DIRECTORY_SEPARATOR . $file)) {
               touch($dir . DIRECTORY_SEPARATOR . $file);
           }
        }
        $realDir = realpath($dir);

        if (false === $realDir)
            throw new InvalidArgumentException(sprintf('Path is invalid, directory "%s" does not exists', $dir));

        $realPath = realpath($filePath);

        if (false !== $realPath && is_dir($realPath))
            throw new InvalidArgumentException(sprintf('Path "%s" must be a file, directory given', $realPath));

        // Somehow, I come in the situation that realpath() returns the requested file and file_exists() returns false.
        // Probably some caching issue. I could not resolve this. So to be sure, I added the file_exists() to
        // the if condition in order to add correct logging information. Because we add the mode 'a', it will not result in an error
        // as the file will still be created butt now at least the logging entry will not be accurate.
        if (false === $realPath || !file_exists($realPath)) {
            if (!$create)
                throw new InvalidArgumentException(sprintf('%s : Path "%s" does not exists', __METHOD__, $filePath));

            if (!is_writable($realDir))
                throw new InvalidArgumentException(sprintf('%s : Cannot create log file "%s" directory "%s" is not writable',__METHOD__,  $file, $realDir));

            $realPath = $realDir . DIRECTORY_SEPARATOR . $file;
            $this->_fileHandler = fopen($realPath, 'a');

            if(false === $this->_fileHandler)
                throw new Exception (sprintf('%s : Cannot create log file, failed to open or create "%s"', __METHOD__, $realPath));

            $this->log(LogLevel::INFO, '-- Log file created --', [
                'path' => $realPath,
                'directory' => $realDir,
                'file' => $file,
                'create' => $create,
                'resource' => $this->_fileHandler,
            ]);

        } else {
            $this->_fileHandler = fopen($realPath, 'a');

            if(false === $this->_fileHandler)
                throw new Exception (sprintf('%s : Cannot create log file, failed to open or create "%s"', __METHOD__, $realPath));

            $this->log(LogLevel::INFO, '-- Log file opened --');
        }
    }


    /**
     * @param $level
     * @param Stringable|string $message
     * @param array $context
     * @return void
     * @throws Exception
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (!$this->hasLevel($level)) return;

        /**
         * @see https://www.php.net/manual/en/datetime.format.php
         *
         * Microseconds. Note that date() will always generate 000000 since it takes an int parameter, whereas
         * DateTime::format() does support microseconds if DateTime was created with microseconds.
        */
        $date = new DateTime();
        $timestamp = $date->format('Y-m-d h:i:s.u' );
        //$timestamp = date('Y-m-d h:i:s.u', time());
        if (false === fwrite($this->_fileHandler, sprintf("[%s] %-10s %s\n", $timestamp, strtoupper($level), $message)))
            throw new Exception(__METHOD__ . ': Writing to log failed unexpectedly');

        if (count($context)) {
            if (false === fwrite($this->_fileHandler, print_r($context,true) . "\n"))
                throw new Exception(__METHOD__ . ': Writing to log failed unexpectedly');
        }

    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->log(LogLevel::INFO, '-- Log file closed --');
        fclose($this->_fileHandler);
    }

}
