<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Monitors;

use Perf2k2\Monitre\AbstractMonitor;
use Perf2k2\Monitre\Connection;
use Perf2k2\Monitre\Exceptions\ValidationException;
use Perf2k2\Monitre\Helpers\ConsoleOutputParser;
use Perf2k2\Monitre\Helpers\Size;

class FileMonitor extends AbstractMonitor
{
    protected $path;

    public function __construct(Connection $connection, string $path)
    {
        if (empty($path)) {
            throw new ValidationException('Path not specified');
        }

        parent::__construct($connection);
        $this->path;
    }

    public function getSize(): Size
    {
        $result = $this->connection->exec("stat {$this->path}");

        $parser = new ConsoleOutputParser($result);
        $string = $parser->parseLine(1, '/Size: (\d+)/')[1];

        return new Size((int) $string);
    }

    public function getModifyTime(): \DateTimeImmutable
    {
        $result = $this->connection->exec("stat {$this->path}");

        $parser = new ConsoleOutputParser($result);
        $string = $parser->parseLine(5, '/Modify: ([\w\-\s:]+)/')[1];

        return new \DateTimeImmutable($string);
    }

    public function getContent(): string
    {
        return $this->connection->exec("cat {$this->path}");
    }

    public function getLastLines(int $number = 10): string
    {
        return $this->connection->exec("tail -n{$number} {$this->path}");
    }

    public function getHeadLines(int $number = 10): string
    {
        return $this->connection->exec("head -n{$number} {$this->path}");
    }
}