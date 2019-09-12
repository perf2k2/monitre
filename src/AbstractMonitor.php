<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

abstract class AbstractMonitor
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}