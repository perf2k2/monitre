<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Tests\Acceptance;

use Dotenv\Dotenv;
use Perf2k2\Monitre\Authenticators\PasswordAuthenticator;
use Perf2k2\Monitre\Connection;
use Perf2k2\Monitre\Exceptions\ConnectionException;
use Perf2k2\Monitre\Exceptions\ValidationException;
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

        try {
            $this->expectException(ConnectionException::class);
            $this->expectExceptionMessage('Unknown address: wronghost');
            new Connection('wronghost', new PasswordAuthenticator('user', 'password'), 2020);
        } catch (ConnectionException $e) {
            try {
                $this->expectException(ConnectionException::class);
                $this->expectExceptionMessage('Unable to connect to 11.11.11.11 on port 22');
                new Connection('11.11.11.11', new PasswordAuthenticator('user', 'password'));
            } catch (ConnectionException $e) {
                $this->expectException(ValidationException::class);
                $this->expectExceptionMessage('Empty command body specified');
                $connection->exec('');
            }
        }
    }
}