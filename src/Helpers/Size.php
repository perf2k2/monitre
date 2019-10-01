<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Helpers;

use Perf2k2\Monitre\Exceptions\ValidationException;

class Size
{
    protected $bytes;

    public function __construct(float $bytes)
    {
        if ($bytes < 0) {
            throw new ValidationException("A negative number not allowed: {$bytes}");
        }

        $this->bytes = $bytes;
    }

    public function getBytes(int $precision = 0): float
    {
        return \round($this->bytes, $precision);
    }

    public function getKilobytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000, $precision);
    }

    public function getMegabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000, $precision);
    }

    public function getGigabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000 / 1000, $precision);
    }

    public function getTerabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000 / 1000 / 1000, $precision);
    }
}