<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Monitors;

use Perf2k2\Remmoit\AbstractMonitor;
use Perf2k2\Remmoit\Connection;
use Perf2k2\Remmoit\Exceptions\ValidationException;

class DiskUsageMonitor extends AbstractMonitor
{
    private $data = [];

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);

        $result = $connection->exec('df');
        foreach (explode("\n", $result) as $i => $line) {
            if ($i === 0 || empty($line)) {
                continue;
            }

            preg_match('/(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+([\d%]+)\s+(.+)/', $line, $matches);
            [, , , , , , $path] = $matches;
            $this->data[$path] = array_slice($matches, 1);
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