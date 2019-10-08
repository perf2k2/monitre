<?php
declare(strict_types=1);

namespace Perf2k2\Monitre;

abstract class AbstractMonitor
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}