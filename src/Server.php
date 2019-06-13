<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

class Server
{
    private $address;
    private $authenticator;
    private $port;

    public function __construct(string $address, AuthenticatorInterface $authenticator, int $port = 22)
    {
        $this->address = $address;
        $this->authenticator = $authenticator;
        $this->port = $port;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAuthenticator(): AuthenticatorInterface
    {
        return $this->authenticator;
    }

    public function getPort(): int
    {
        return $this->port;
    }
}