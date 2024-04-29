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

    /**
     * The levels to be logged.
     * @var array
     */
    protected array $_levels = [];

    /**
     * Set the levels to be logged. Levels are case insensitive.
     * @param array $levels
     * @return $this
     */
    public function setLevels(array $levels): static
    {
        $this->_levels = array_map('strtolower', $levels);
        return $this;
    }

    /**
     * Retuns the levels to be logged
     * @return array
     */
    public function getLevels(): array
    {
        return $this->_levels;
    }

    /**
     * Returns true when the level __$level__ is to belogged. False otherwise
     * @param string $level
     * @return bool
     */
    public function hasLevel(string $level): bool
    {
        if (count($this->_levels) === 0) return true;
        return in_array(strtolower($level), $this->_levels, );
    }



}