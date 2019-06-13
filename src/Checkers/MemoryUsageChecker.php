<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Checkers;

use Perf2k2\Remmoit\AbstractChecker;
use Perf2k2\Remmoit\Connection;

class MemoryUsageChecker extends AbstractChecker
{
    private $data = [];

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $result = $connection->exec('free');

        $line = explode("\n", $result)[1];
        preg_match('/(\w+:)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $line, $matches);
        [, $type] = $matches;
        $this->data[$type] = array_slice($matches, 1);
    }

    public function getUsagePercent(): float
    {
        [, $total, $used] = $this->data['Mem:'];
        return round((int) $used / (int) $total * 100, 2);
    }
}