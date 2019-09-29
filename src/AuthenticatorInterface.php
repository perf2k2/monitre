<?php
declare(strict_types=1);

namespace Perf2k2\Monitre;

interface AuthenticatorInterface
{
    public function auth($connection);
}