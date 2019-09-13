<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Tests\Acceptance;

use Dotenv\Dotenv;
use Perf2k2\Remmoit\Authenticators\PasswordAuthenticator;
use Perf2k2\Remmoit\Connection;
use Perf2k2\Remmoit\Exceptions\ExecutionException;
use PHPUnit\Framework\TestCase;

class CommandExecutionTest extends TestCase
{
    public function testConnection(): void
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

        $connection = new Connection(getenv('REMOTE_ADDRESS'), new PasswordAuthenticator(
            getenv('REMOTE_USER'),
            getenv('REMOTE_PASSWORD')
        ));

        $this->assertSame("test\n", $connection->exec('echo test'));

        $this->expectException(ExecutionException::class);
        $this->expectExceptionMessage('Unable to get command output content: "echo1 test"');
        $this->assertSame("test\n", $connection->exec('echo1 test'));
    }
}