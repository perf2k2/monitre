<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Monitors;

use Perf2k2\Remmoit\AbstractMonitor;
use Perf2k2\Remmoit\Connection;
use Perf2k2\Remmoit\Exceptions\ValidationException;
use Perf2k2\Remmoit\Helpers\ConsoleOutputParser;

class DiskUsageMonitor extends AbstractMonitor
{
    private $data = [];

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $result = $connection->exec('df');
        $parser = new ConsoleOutputParser($result);

        foreach ($parser->getLinesIterator([0], true) as $line) {
            $data = $parser->parseString($line, '/(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+([\d%]+)\s+(.+)/');
            $path = $data[6];
            $this->data[$path] = array_slice($data, 1);
        }
    }

    public function getUsagePercent(string $path): float
    {
        if (empty($path)) {
            throw new ValidationException('Mount path not specified');
        }

        [, $size, $used] = $this->data[$path];
        return round((int) $used / (int) $size * 100, 2);
    }
}