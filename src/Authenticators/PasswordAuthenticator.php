<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Authenticators;

use Perf2k2\Remmoit\AuthenticatorInterface;
use Perf2k2\Remmoit\Exceptions\AuthenticationException;

class PasswordAuthenticator implements AuthenticatorInterface
{
    private $user;
    private $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function auth($connection)
    {
        try {
            ssh2_auth_password($connection, $this->user, $this->password);
        } catch (\Throwable $e) {
            throw new AuthenticationException(str_replace('ssh2_auth_password(): ', '', $e->getMessage()));
        }
    }
}