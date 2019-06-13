<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

use Psr\Log\LoggerAwareInterface;

interface CheckerInterface extends LoggerAwareInterface
{
    public function runAll($connection): void;
}