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

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

abstract class BaseLogger implements LoggerInterface
{

    use LoggerTrait;

    protected array $_levels = [];

    public function setLevels(array $levels): static
    {
        $this->_levels = $levels;
        return $this;
    }
    public function getLevels(): array
    {
        return $this->_levels;
    }

    public function hasLevel(string $level): bool
    {
        if (count($this->_levels) === 0) return true;
        return isset($this->getLevels()[$level]);
    }



}