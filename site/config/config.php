<?php
declare(strict_types=1);

$local = PHP_SAPI === 'cli-server' && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);

$config = [
    'debug' => $local,
    'panel' => ['install' => $local],
    'whoops' => false,
    'thumbs' => ['quality' => 82],
    'markdown' => ['extra' => true],
    'ja' => [
        'local' => $local,
        'canonical' => getenv('JA_CANONICAL_URL') ?: null,
        'inquiries' => dirname(__DIR__, 2) . '/storage/inquiries',
        'mail' => [
            'mode' => $local ? 'log' : 'smtp',
            'from' => getenv('JA_MAIL_FROM') ?: '',
            'to' => getenv('JA_MAIL_TO') ?: '',
            'host' => getenv('JA_SMTP_HOST') ?: '',
            'port' => (int)(getenv('JA_SMTP_PORT') ?: 587),
            'security' => getenv('JA_SMTP_SECURITY') ?: 'tls',
            'username' => getenv('JA_SMTP_USERNAME') ?: '',
            'password' => getenv('JA_SMTP_PASSWORD') ?: '',
        ],
    ],
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'action' => function () {
                $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                foreach (site()->index()->listed()->add(page('home'))->add(page('blogs'))->add(page('privacy')) as $entry) {
                    if ($entry->id() !== 'error') $xml .= '<url><loc>' . htmlspecialchars(ja_canonical($entry), ENT_XML1, 'UTF-8') . '</loc></url>';
                }
                // Historic articles are deliberately unlisted in the main navigation.
                foreach (page('blogs')->children()->published() as $entry) {
                    $xml .= '<url><loc>' . htmlspecialchars(ja_canonical($entry), ENT_XML1, 'UTF-8') . '</loc></url>';
                }
                return new Kirby\Http\Response($xml . '</urlset>', 'application/xml');
            },
        ],
        [
            'pattern' => 'robots.txt',
            'action' => function () {
                $live = option('ja.canonical');
                $text = $live ? "User-agent: *\nDisallow: /panel\nDisallow: /api\nSitemap: " . rtrim($live, '/') . "/sitemap.xml\n" : "User-agent: *\nDisallow: /\n";
                return new Kirby\Http\Response($text, 'text/plain');
            },
        ],
    ],
    'hooks' => [
        'route:before' => function () {
            header('X-Content-Type-Options: nosniff');
            header('Referrer-Policy: strict-origin-when-cross-origin');
            header('X-Frame-Options: SAMEORIGIN');
            header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
            if (!option('ja.canonical')) header('X-Robots-Tag: noindex, nofollow');
            if ($base = option('ja.canonical')) {
                $host = strtolower($_SERVER['HTTP_HOST'] ?? '');
                $expected = strtolower(parse_url($base, PHP_URL_HOST) ?? '');
                $https = ($_SERVER['HTTPS'] ?? '') === 'on';
                if (!option('ja.local') && $expected && ($host !== $expected || (str_starts_with($base, 'https:') && !$https))) {
                    $uri = $_SERVER['REQUEST_URI'] ?? '/';
                    go(rtrim($base, '/') . '/' . ltrim($uri, '/'), in_array($_SERVER['REQUEST_METHOD'] ?? '', ['GET', 'HEAD']) ? 301 : 307);
                }
            }
        },
    ],
];

// Optional untracked private settings, usable on both cPanel and CLI maintenance.
if (is_file(__DIR__ . '/config.local.php')) {
    $config = array_replace_recursive($config, require __DIR__ . '/config.local.php');
}
return $config;
