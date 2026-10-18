<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') exit(1);
$root = dirname(__DIR__);
if (!is_file($root . '/kirby/bootstrap.php') || !is_file($root . '/vendor/autoload.php')) {
    fwrite(STDERR, "Run composer install before packaging.\n"); exit(1);
}
$destination = $root . '/dist';
if (!is_dir($destination)) mkdir($destination, 0755, true);
$path = $destination . '/jitamani-cpanel-' . gmdate('Ymd-His') . '.zip';
$zip = new ZipArchive();
if ($zip->open($path, ZipArchive::CREATE | ZipArchive::EXCL) !== true) throw new RuntimeException('Could not create package');
$files = 0;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)) as $file) {
    $relative = substr($file->getPathname(), strlen($root) + 1);
    if (preg_match('~^(?:\.git/|\.github/|dist/|storage/|artifacts/|tests/|docs/|media/|site/(?:accounts|cache|sessions|logs)/)~', $relative)) continue;
    if (preg_match('~^(?:\.env(?:\..*)?|site/config/config\..*\.php|site/config/\.license)$~', $relative)) continue;
    if ($file->isLink() || $file->getBasename() === '.DS_Store') continue;
    $zip->addFile($file->getPathname(), $relative); $files++;
}
$zip->close();
echo "Created $path ($files files). Private settings, accounts and inquiries excluded.\n";
