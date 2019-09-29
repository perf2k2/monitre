<?php
declare(strict_types=1);

namespace Perf2k2\Monitre\Authenticators;

use Perf2k2\Monitre\AuthenticatorInterface;
use Perf2k2\Monitre\Exceptions\AuthenticationException;
use Perf2k2\Monitre\Exceptions\ValidationException;

class PasswordAuthenticator implements AuthenticatorInterface
{
    private $user;
    private $password;

    public function __construct(string $user, string $password)
    {
        if (empty($user)) {
            throw new ValidationException('User not specified');
        }
        if ( empty($password)) {
            throw new ValidationException('Password not specified');
        }

        $this->user = $user;
        $this->password = $password;
    }

    public function auth($connection)
    {
        if (!is_resource($connection)) {
            throw new AuthenticationException('Connection must be a valid resource type');
        }

        try {
            ssh2_auth_password($connection, $this->user, $this->password);
        } catch (\Throwable $e) {
            throw new AuthenticationException(str_replace('ssh2_auth_password(): ', '', $e->getMessage()));
        }
    }
}