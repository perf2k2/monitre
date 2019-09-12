<?php /** @noinspection PhpParamsInspection */

use Perf2k2\Remmoit\Checkers\DiskUsageChecker;
use Perf2k2\Remmoit\Connection;
use PHPUnit\Framework\TestCase;

class DiskUsageCheckerTest extends TestCase
{

    public function testGetUsagePercent()
    {
        $connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $connection->expects($this->any())->method('exec')->willReturn('Filesystem     1K-blocks      Used Available Use% Mounted on
udev             8130108         0   8130108   0% /dev
tmpfs            1632936      9604   1623332   1% /run
/dev/sda1      107085856  86889316  14733756  86% /
tmpfs            8164680    144360   8020320   2% /dev/shm
tmpfs               5120         4      5116   1% /run/lock
tmpfs            8164680         0   8164680   0% /sys/fs/cgroup
/dev/sdb1      956762684 496419456 460343228  52% /media/hdd
tmpfs            1632936         0   1632936   0% /run/user/118
tmpfs            1632936        28   1632908   1% /run/user/1000');
        $checker = new DiskUsageChecker($connection);

        $this->assertSame(81.14, $checker->getUsagePercent('/'));
    }
}
