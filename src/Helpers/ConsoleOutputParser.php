<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Helpers;

use Perf2k2\Monitre\Exceptions\ValidationException;

class ConsoleOutputParser
{
    private $content;
    private $lines;

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->lines = explode("\n", $content);
    }

    public function getLines(): array
    {
        return $this->lines;
    }

    public function getLine(int $index): string
    {
        if (!array_key_exists($index, $this->lines)) {
            throw new ValidationException("Line with index {$index} not exists at console output");
        }

        return $this->lines[$index];
    }

    public function getLinesIterator(array $linesToExclude = [], bool $removeEmptyLines = false): \Generator
    {
        foreach ($this->lines as $i => $line) {
            if (($removeEmptyLines && empty($line)) || in_array($i, $linesToExclude)) {
                continue;
            }

            yield $i => $line;
        }
    }

    public function parseString(string $content, string $palette): array
    {
        if (empty($content)) {
            return [];
        }

        if (empty($palette)) {
            throw new ValidationException('Empty palette specified for parse string');
        }

        preg_match($palette, $content, $matches);
        return $matches;
    }

    public function parseLine(int $number, string $palette): array
    {
        $content = $this->getLine($number);
        return $this->parseString($content, $palette);
    }
}