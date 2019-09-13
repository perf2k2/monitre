<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

use Perf2k2\Remmoit\Exceptions\ConnectionException;
use Perf2k2\Remmoit\Exceptions\ExecutionException;
use Perf2k2\Remmoit\Exceptions\ValidationException;

class Connection
{
    private $resource;

    public function __construct(string $address, AuthenticatorInterface $authenticator, int $port = 22)
    {
        if (empty($address)) {
            throw new ValidationException('Empty host address specified');
        }

        try {
            if (!$this->resource = ssh2_connect($address, $port)) {
                throw new ConnectionException("Unable to connect to {$address}:{$port}");
            }
        } catch (\Throwable $e) {
            if (strpos($e->getMessage(), 'php_network_getaddresses')) {
                throw new ConnectionException("Unknown address: {$address}");
            }

            throw new ConnectionException(str_replace('ssh2_connect(): ', '', $e->getMessage()));
        }

        $authenticator->auth($this->resource);
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function exec(string $command): string
    {
        if (empty($command)) {
            throw new ValidationException('Empty command body specified');
        }

        $stream = ssh2_exec($this->getResource(), $command);

        if (!$stream) {
            throw new ExecutionException("Unable execute command \"{$command}\"");
        }

        if (!stream_set_blocking($stream, true)) {
            throw new ExecutionException("Unable to set stream blocking for command \"{$command}\"");
        }

        $output = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $content = stream_get_contents($output);

        if (!$content) {
            throw new ExecutionException("Unable to get command output content: \"{$command}\"");
        }

        return $content;
    }
}