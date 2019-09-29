<?php

use Perf2k2\Monitre\Exceptions\ValidationException;
use Perf2k2\Monitre\Helpers\ConsoleOutputParser;
use PHPUnit\Framework\TestCase;

class ConsoleOutputParserTest extends TestCase
{
    private static $parser;

    public static function setUpBeforeClass()
    {
        self::$parser  = new ConsoleOutputParser('123 zxc
456 vbn');
    }

    public function testParseLine()
    {
        $this->assertSame(['123 zxc', '123', 'zxc'], self::$parser->parseLine(0, '/(\d+)\s{1}(\w+)/'));
    }

    public function testGetLine()
    {
        $this->assertSame('456 vbn', self::$parser->getLine(1));

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Line with index 3 not exists at console output');
        self::$parser->getLine(3);
    }

    public function testGetLinesIterator()
    {
        $this->assertIsIterable(self::$parser->getLinesIterator());
    }

    public function testParseString()
    {
        $this->assertSame(['456 vbn', '456', 'vbn'], self::$parser->parseString('456 vbn', '/(\d+)\s{1}(\w+)/'));

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Empty palette specified for parse string');
        self::$parser->parseString('456 vbn', '');
    }
}
