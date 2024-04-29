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

use Stringable;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * This Logger will pass the log entry to the given callback
 */
class PassThroughLogger extends BaseLogger
{

    /**
     * @ignore Do not show in generated documentation
     * @var mixed|callable The callback to pass the log entry to
     */
    private mixed $_callback;

    /**
     * @param mixed $callback Callback to receive the log entry
     */
    public function __construct(mixed $callback)
    {
        if (!is_callable($callback))
            throw new InvalidArgumentException(__METHOD__ . ' : Not a valid callback');

        $this->_callback = $callback;
    }

    /**
     * The log entries are passed through the callback.
     *
     * @param string $level See the class LogLevels
     * @param Stringable|string $message
     * @param array $context
     * @return void
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (!$this->hasLevel($level)) return;

        call_user_func($this->_callback, $level, $message, $context);
    }
}