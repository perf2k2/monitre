<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit\Authenticators;

use Perf2k2\Remmoit\AuthenticatorInterface;

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
        ssh2_auth_password($connection, $this->user, $this->password);
    }
}