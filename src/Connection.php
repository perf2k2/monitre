<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

class Connection
{
    private $resource;

    public function __construct(string $address, AuthenticatorInterface $authenticator, int $port = 22)
    {
        $this->resource = ssh2_connect($address, $port);
        $authenticator->auth($this->resource);
    }

    public function getResource()
    {
        return $this->resource;
    }
}