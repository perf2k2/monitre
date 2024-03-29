<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Tests\Acceptance;

use Dotenv\Dotenv;
use Perf2k2\Monitre\Authenticators\PasswordAuthenticator;
use Perf2k2\Monitre\Connection;
use Perf2k2\Monitre\Exceptions\AuthenticationException;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    public function testPasswordAuth(): void
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Authentication failed for wrong using password');
        new Connection('localhost', new PasswordAuthenticator('wrong', 'wrong'));
    }
}