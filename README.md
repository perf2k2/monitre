# Monitre
[![Build Status](https://travis-ci.org/perf2k2/monitre.svg?branch=master)](https://travis-ci.org/perf2k2/monitre)

### About

Library for connecting to remote linux systems and reading key performance and other metrics.
Maybe useful for periodic checking remote machine state and logging situations with wrong values.

### How it works

It uses classes called "monitors" for checking metrics. After connecting to remote host by ssh, monitor 
runs linux command and parse output for getting information. 

### List of monitors

* Memory
    * Usage percent
* Disk
    * Usage percent (by mount path)
* File (by absolute path)
    * Size
    * Modify time
    * Content
    * Last lines
    * Header lines

### Requirements

* PHP >= 7.2
* ext-ssh2

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
if ($fileMonitor->getSize()->asMegabytes() > 100) {
    $logger->warning('File too large!');
}
```