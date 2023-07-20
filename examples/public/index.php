<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class ConsoleLogger implements LoggerInterface
{
    use LoggerTrait;
}
