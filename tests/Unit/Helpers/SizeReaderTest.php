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


    public function testAsGb()
    {
        $this->assertSame(0.0, self::$instance->asGigabytes());
        $this->assertSame(0.015, self::$instance->asGigabytes(3));
    }

    public function testAsKb()
    {
        $this->assertSame(14734.0, self::$instance->asKilobytes());
        $this->assertSame(14733.756, self::$instance->asKilobytes(3));
    }

    public function testAsTb()
    {
        $this->assertSame(0.0, self::$instance->asTerabytes());
        $this->assertSame(0, bccomp(0.000015, self::$instance->asTerabytes(3)));
    }

    public function testAsMb()
    {
        $this->assertSame(15.0, self::$instance->asMegabytes());
        $this->assertSame(14.734, self::$instance->asMegabytes(3));
    }

    public function testAsBytes()
    {
        $this->assertSame(14733756.0, self::$instance->asBytes());
        $this->assertSame(14733756.000, self::$instance->asBytes(3));
    }
}
