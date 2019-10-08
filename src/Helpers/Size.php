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

    public function asBytes(int $precision = 0): float
    {
        return \round($this->bytes, $precision);
    }

    public function asKilobytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000, $precision);
    }

    public function asMegabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000, $precision);
    }

    public function asGigabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000 / 1000, $precision);
    }

    public function asTerabytes(int $precision = 0): float
    {
        return \round($this->bytes / 1000 / 1000 / 1000 / 1000, $precision);
    }
}