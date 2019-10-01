<?php

use Perf2k2\Monitre\Helpers\Size;
use PHPUnit\Framework\TestCase;

class SizeReaderTest extends TestCase
{
    private static $instance;

    protected function setUp()
    {
        parent::setUp();
        self::$instance = new Size(14733756);
    }

    public function testConstruct()
    {
        $this->expectExceptionMessage('A negative number not allowed: -0.00234234');
        new Size(-0.00234234);
    }


    public function testGb()
    {
        $this->assertSame(0.0, self::$instance->getGigabytes());
        $this->assertSame(0.015, self::$instance->getGigabytes(3));
    }

    public function testKb()
    {
        $this->assertSame(14734.0, self::$instance->getKilobytes());
        $this->assertSame(14733.756, self::$instance->getKilobytes(3));
    }

    public function testTb()
    {
        $this->assertSame(0.0, self::$instance->getTerabytes());
        $this->assertSame(0, bccomp(0.000015, self::$instance->getTerabytes(3)));
    }

    public function testMb()
    {
        $this->assertSame(15.0, self::$instance->getMegabytes());
        $this->assertSame(14.734, self::$instance->getMegabytes(3));
    }

    public function testB()
    {
        $this->assertSame(14733756.0, self::$instance->getBytes());
        $this->assertSame(14733756.000, self::$instance->getBytes(3));
    }
}
