<?php
declare(strict_types=1);

namespace Perf2k2\Remmoit;

interface AuthenticatorInterface
{
    public function auth($connection);
}