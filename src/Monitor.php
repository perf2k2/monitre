<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

class Monitor
{
    private $servers = [];

    public function addChecks(Server $server, array $checks): self
    {
        return $this;
    }

    public function run(): void
    {

    }
}