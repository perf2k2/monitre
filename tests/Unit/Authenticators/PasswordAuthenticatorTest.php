<?php

use Perf2k2\Monitre\Authenticators\PasswordAuthenticator;
use Perf2k2\Monitre\Exceptions\AuthenticationException;
use Perf2k2\Monitre\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class PasswordAuthenticatorTest extends TestCase
{

    public function test__construct()
    {
        try {
            $this->expectException(ValidationException::class);
            $this->expectExceptionMessage('User not specified');
            new PasswordAuthenticator('', '');
        } catch (Exception $e) {
            $this->expectException(ValidationException::class);
            $this->expectExceptionMessage('Password not specified');
            new PasswordAuthenticator('user', '');
        }
    }

    public function testAuth()
    {
        $auth = new PasswordAuthenticator('user', 'password');

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Connection must be a valid resource type');
        $auth->auth('connection');
    }
}
