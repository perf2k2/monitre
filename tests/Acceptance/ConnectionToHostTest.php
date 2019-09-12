<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Tests\Acceptance;

use Dotenv\Dotenv;
use Perf2k2\Remmoit\Authenticators\PasswordAuthenticator;
use Perf2k2\Remmoit\Connection;
use PHPUnit\Framework\TestCase;

class ConnectionToHostTest extends TestCase
{
    public function testConnection(): void
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

        $connection = new Connection(getenv('REMOTE_ADDRESS'), new PasswordAuthenticator(
            getenv('REMOTE_USER'),
            getenv('REMOTE_PASSWORD')
        ));

        $this->assertIsResource($connection->getResource());
    }
}