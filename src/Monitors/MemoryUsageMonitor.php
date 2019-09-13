<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Monitors;

use Perf2k2\Remmoit\AbstractMonitor;
use Perf2k2\Remmoit\Connection;
use Perf2k2\Remmoit\Helpers\ConsoleOutputParser;

class MemoryUsageMonitor extends AbstractMonitor
{
    private $data = [];

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $result = $connection->exec('free');
        $parser = new ConsoleOutputParser($result);
        $data = $parser->parseLine(1, '/(\w+:)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/');
        $type = $data[1];

        $this->data[$type] = array_slice($data, 1);
    }

    public function getUsagePercent(): float
    {
        [, $total, $used] = $this->data['Mem:'];
        return round((int) $used / (int) $total * 100, 2);
    }
}