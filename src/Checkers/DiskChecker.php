<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Checkers;

use Perf2k2\Remmoit\CheckerInterface;
use Perf2k2\Remmoit\Connection;

class DiskChecker implements CheckerInterface
{
    private $connection;
    private $data = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $stream = ssh2_exec($connection->getResource(), 'df');
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $result = stream_get_contents($stream_out);

        foreach (explode("\n", $result) as $i => $line) {
            if ($i === 0 || empty($line)) {
                continue;
            }

            preg_match('/(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+([\d%]+)\s+(.+)/', $line, $matches);
            [, , , , , , $path] = $matches;
            $this->data[$path] = array_slice($matches, 1);
        }
    }

    public function getDiskUsagePercent(string $path): float
    {
        [, $size, $used] = $this->data[$path];
        return round((int) $used / (int) $size * 100, 2);
    }
}