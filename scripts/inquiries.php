<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') exit(1);
require dirname(__DIR__) . '/kirby/bootstrap.php';
new Kirby(['roots' => ['index' => dirname(__DIR__)]]);

$command = $argv[1] ?? '';
if (!in_array($command, ['retry', 'purge'], true)) {
    fwrite(STDERR, "Usage: php scripts/inquiries.php retry | purge [retention-days]\n"); exit(1);
}
$directory = JitamaniInquiries::directory();
$lock = fopen($directory . '/.maintenance.lock', 'c');
if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) exit(0);
$processed = 0;
foreach (glob($directory . '/inquiry-*.json') as $path) {
    $record = json_decode(file_get_contents($path), true);
    if (!$record) continue;
    if ($command === 'purge') {
        $days = max(1, (int)($argv[2] ?? 30));
        if (strtotime($record['created']) < time() - $days * 86400) { unlink($path); $processed++; }
    } elseif ($record['state'] === 'pending') {
        try {
            JitamaniInquiries::deliver($record);
            $record['state'] = option('ja.local') ? 'local-test' : 'sent';
            JitamaniInquiries::save($record); $processed++;
        } catch (Throwable $e) {
            fwrite(STDERR, 'Delivery still pending for reference ' . $record['id'] . ".\n");
        }
    }
}
if ($command === 'purge') foreach (glob($directory . '/rate-*.json') as $file) if (filemtime($file) < time() - 86400) unlink($file);
flock($lock, LOCK_UN); fclose($lock);
echo $command . ': ' . $processed . " record(s) processed. No personal data printed.\n";
