<?php

use Perf2k2\Remmoit\Authenticators\PasswordAuthenticator;
use Perf2k2\Remmoit\Connection;
use Perf2k2\Remmoit\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{

    public function test__construct()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Empty host address specified');
        new Connection('', new PasswordAuthenticator('user', 'password'));
    }
}
