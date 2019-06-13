<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Checkers;

use Perf2k2\Remmoit\CheckerInterface;

class DiskUsageChecker implements CheckerInterface
{
    private $checks = [];

    public function ifPercentUsageMoreThan(string $path, int $percent): self
    {
        $this->checks[] = ['ifPercentUsageMoreThan', $path, $percent];
        return $this;
    }

    public function runAll($connection): void
    {
        $stream = ssh2_exec($connection, 'df');
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $result = stream_get_contents($stream_out);
        $data = [];

        foreach (explode("\n", $result) as $i => $line) {
            if ($i === 0 || empty($line)) {
                continue;
            }

            preg_match('/(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+([\d%]+)\s+(.+)/', $line, $matches);
            [, , , , , , $path] = $matches;
            $data[$path] = array_slice($matches, 1);
        }

        foreach ($this->checks as $check) {
            $name = $check[0];

            if ($name === 'ifPercentUsageMoreThan') {
                foreach ($data as $path => [$fs, $size, $used, $avail, $usePercent, $path]) {
                    if ($path === $check[1]) {
                        $calculatedUsedPercent = round((int) $used / (int) $size * 100, 2);

                        if ($calculatedUsedPercent > $check[2]) {
                            echo "Ends space in '{$path}': {$calculatedUsedPercent}% occupied!\n";
                        }
                    }
                }
            }
        }
    }
}