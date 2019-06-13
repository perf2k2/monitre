<?php
declare(strict_types=1);

$connection = ssh2_connect('', 22);
ssh2_auth_password($connection, '', '');

$stream = ssh2_exec($connection, 'df');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

$result = stream_get_contents($stream_out);
$data = [];

foreach (explode("\n", $result) as $i => $line) {
    if ($i === 0 || empty($line)) {
        continue;
    }

    preg_match('/(\w+)\s+(\d+)\s+(\d+)\s+(\d+)\s+([\d%]+)\s+(.+)/', $line, $matches);
    [, $fs, $size, $used, $avail, $usePercent, $path] = $matches;
    $data[$path] = array_slice($matches, 1);

    $calcedUsedPercent = round((int) $used / (int) $size * 100, 2);

    if ($calcedUsedPercent > 80) {
        echo "Караул, в разделе '{$path}' место заканчивается! Занято {$calcedUsedPercent}%!\n";
    }
}