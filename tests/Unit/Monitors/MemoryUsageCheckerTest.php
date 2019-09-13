<?php /** @noinspection PhpParamsInspection */

use Perf2k2\Remmoit\Monitors\MemoryUsageMonitor;
use Perf2k2\Remmoit\Connection;
use PHPUnit\Framework\TestCase;

class MemoryUsageCheckerTest extends TestCase
{

    public function testGetUsagePercent()
    {
        $connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $connection->expects($this->any())->method('exec')->willReturn('              total        used        free      shared  buff/cache   available
Mem:       16329360     9242516      425096      160580     6661748     6382772
Swap:       8290300         512     8289788
');
        $checker = new MemoryUsageMonitor($connection);

        $this->assertSame(56.6, $checker->getUsagePercent());
    }
}
