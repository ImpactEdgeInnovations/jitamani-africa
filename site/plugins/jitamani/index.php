<?php
declare(strict_types=1);

require_once __DIR__ . '/inquiries.php';

Kirby::plugin('jitamani/website', []);

function ja_canonical($page): string
{
    $base = option('ja.canonical');
    return $base ? rtrim($base, '/') . ($page->isHomePage() ? '/' : '/' . $page->uri()) : $page->url();
}

function ja_whatsapp(): string
{
    return 'https://wa.me/' . preg_replace('/\D/', '', site()->whatsapp()->value()) . '?text=' . rawurlencode('Hello! I would like to talk about a project.');
}

function ja_icon(string $name = 'arrow'): string
{
    $paths = [
        'arrow' => '<path d="M4 12h15m-6-6 6 6-6 6"/>',
        'diagonal' => '<path d="M5 19 19 5M5 5h14v14"/>',
        'whatsapp' => '<path d="M20 11.5a8.4 8.4 0 0 1-12.5 7.4L3 20l1.2-4.4A8.4 8.4 0 1 1 20 11.5Z"/><path d="M8 7.5c0 4.2 2.5 6.7 6.5 7l1-2-2-1-1 1c-1.5-.7-2.5-1.8-3-3l1-1-1-2Z"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? $paths['arrow']) . '</svg>';
}

function ja_image($file, string $sizes = '100vw', bool $priority = false, string $class = ''): void
{
    if (!$file) return;
    snippet('image', compact('file', 'sizes', 'priority', 'class'));
}

function ja_services()
{
    return page('services')->services()->toStructure();
}
