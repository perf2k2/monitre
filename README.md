# Monitre

### About

Library for connecting to remote linux systems and reading key performance and other metrics.
Maybe useful for periodic checking remote machine state and logging situations with wrong values.

### Installation

```shell
composer require perf2k2/monitre
```

### Usage

```php
$logger = new Logger();
$server = new Connection('ip', new PasswordAuthenticator('user', 'password'));

$memoryMonitor = new MemoryUsageMonitor($server);
if ($memoryMonitor->getUsagePercent() > 90) {
    $logger->warning('High memory usage!');
}

$diskMonitor = new DiskUsageMonitor($server);
if ($diskMonitor->getUsagePercent() > 90) {
    $logger->warning('High disk usage!');
}

$fileMonitor = new FileMonitor($server, '/path/to/file');
if ($fileMonitor->getSize()/1024/1024 > 100) {
    $logger->warning('File too large!');
}
```