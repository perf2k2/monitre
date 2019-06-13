<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

class Monitor
{
    /**
     * @var Server[]
     */
    private $servers = [];
    /**
     * @var CheckerInterface[]
     */
    private $checkers = [];

    public function addChecks(Server $server, array $checkers): self
    {
        if (!array_key_exists($server->getAddress(), $this->servers)) {
            $this->servers[$server->getAddress()] = $server;
        }

        $this->servers[$server->getAddress()] = $server;
        $this->checkers[$server->getAddress()] = $checkers;

        return $this;
    }

    public function run(): void
    {
        foreach ($this->servers as $server) {
            $connection = ssh2_connect($server->getAddress(), $server->getPort());
            $server->getAuthenticator()->auth($connection);

            foreach ($this->checkers[$server->getAddress()] as $checker) {
                /** @var $checker CheckerInterface */
                $checker->runAll($connection);
            }
        }
    }
}