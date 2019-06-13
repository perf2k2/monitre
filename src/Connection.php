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

    public function exec(string $command): string
    {
        $stream = ssh2_exec($this->getResource(), $command);
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

        return stream_get_contents($stream_out);
    }
}