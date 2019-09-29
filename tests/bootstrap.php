<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Composer\Autoload\ClassLoader;

$classLoader = new ClassLoader();
$classLoader->addPsr4("Perf2k2\\Monitre\\Tests\\", __DIR__, true);
$classLoader->register();