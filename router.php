<?php
declare(strict_types=1);

// Match the private-path protections used by Apache, including URL-encoded paths.
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
if (preg_match('~(?:^|/)\.(?!well-known/)~', $path) || preg_match('~^/(?:site(?:/|$)|content(?:/|$)|vendor(?:/|$)|kirby(?:/|$)|storage(?:/|$)|scripts(?:/|$)|tests(?:/|$)|docs(?:/|$)|composer\.(?:json|lock)|router\.php)~i', $path)) {
    http_response_code(404);
    echo 'Not found';
    return true;
}
if ($path !== '/' && is_file(__DIR__ . $path)) {
    return false;
}
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
