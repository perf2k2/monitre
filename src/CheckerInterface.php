<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

interface CheckerInterface
{
    public function runAll($connection): void;
}