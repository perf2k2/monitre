<?php /** @noinspection PhpParamsInspection */

use Perf2k2\Monitre\Connection;
use Perf2k2\Monitre\Exceptions\ValidationException;
use Perf2k2\Monitre\Monitors\FileMonitor;
use PHPUnit\Framework\TestCase;

class FileMonitorTest extends TestCase
{
    private $connection;
    private $monitor;
    private static $fileContent = "  File: 'symfony.lock'
  Size: 13428           Blocks: 32         IO Block: 4096   regular file
Device: 811h/2065d      Inode: 1079187501  Links: 1
Access: (0664/-rw-rw-r--)  Uid: ( 1000/developer)   Gid: ( 1000/developer)
Access: 2019-09-11 15:12:10.508026448 +0300
Modify: 2019-07-25 22:03:44.912235721 +0300
Change: 2019-07-25 22:03:44.912235721 +0300
 Birth: -

";

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $this->connection->expects($this->any())->method('exec')->willReturn(self::$fileContent);
        $this->monitor = new FileMonitor($this->connection, 'path');
    }

    public function testConstruct()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Path not specified');
        new FileMonitor($this->connection, '');
    }

    public function testGetContent()
    {
        $this->assertSame(self::$fileContent, $this->monitor->getBody()->getContent());
    }

    public function testGetSize()
    {
        $this->assertSame(13428.0, $this->monitor->getSize()->asBytes());
    }

    public function testGetModifyTime()
    {
        $this->assertSame(
            (new DateTimeImmutable('2019-07-25 22:03:44'))->format(DATE_ISO8601),
            $this->monitor->getModifyTime()->format(DATE_ISO8601)
        );
    }
}
