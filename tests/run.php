<?php
declare(strict_types=1);

require dirname(__DIR__) . '/kirby/bootstrap.php';
$temp = sys_get_temp_dir() . '/jitamani-test-' . bin2hex(random_bytes(6));
$kirby = new Kirby(['roots' => ['index' => dirname(__DIR__)], 'options' => ['ja' => ['inquiries' => $temp, 'local' => true, 'mail' => ['mode' => 'log']]]]);
$passed = 0;
function check(bool $condition, string $message): void {
    global $passed;
    if (!$condition) throw new RuntimeException($message);
    $passed++;
    echo "PASS $message\n";
}
try {
    foreach (['home', 'about', 'services', 'work', 'contact', 'blogs', 'privacy', 'error'] as $id) check(page($id) !== null, "Content exists: $id");
    check(ja_services()->count() === 4, 'Four editable services');
    foreach (ja_services() as $service) check($service->title()->isNotEmpty() && $service->slug()->isNotEmpty(), 'Service label and anchor present');
    check(page('work')->children()->listed()->count() === 2, 'Two original project stories only');
    foreach (page('work')->children()->listed() as $project) check($project->cover()->toFile() !== null, 'Project has a real cover photograph');
    foreach (page('blogs')->children()->published() as $article) check($article->date()->toDate('Y') === '2024' && strlen($article->text()->value()) > 2000, 'Original article content and year retained');
    $valid = ['name' => 'Test Visitor', 'email' => 'visitor@example.test', 'phone' => '', 'message' => 'A local test inquiry.'];
    check(JitamaniInquiries::validate($valid) === [], 'Valid inquiry accepted');
    foreach (['name' => '', 'email' => "bad\r\nBcc:other@example.test", 'message' => 'Short', 'phone' => str_repeat('0', 41)] as $field => $bad) check(isset(JitamaniInquiries::validate(array_replace($valid, [$field => $bad]))[$field]), "Invalid $field rejected");
    for ($i = 0; $i < 5; $i++) check(JitamaniInquiries::rateLimit('unit-test-ip'), 'Within rate limit');
    check(!JitamaniInquiries::rateLimit('unit-test-ip'), 'Sixth rapid inquiry blocked');
    $record = array_merge($valid, ['id' => 'test-' . bin2hex(random_bytes(4)), 'created' => gmdate('c'), 'state' => 'pending']);
    $path = JitamaniInquiries::save($record);
    check(json_decode(file_get_contents($path), true)['message'] === $valid['message'], 'Recovery record is durable');
    check((fileperms($path) & 0777) === 0600, 'Recovery record is private');
    JitamaniInquiries::deliver($record);
    check(true, 'Local log mode accepts without external email');
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__) . '/site/blueprints')) as $file) {
        if ($file->getExtension() === 'yml') check(is_array(Kirby\Data\Yaml::decode(file_get_contents($file->getPathname()))), 'Valid blueprint: ' . $file->getBasename());
    }
    $kirby->impersonate('kirby');
    $sections = site()->blueprint()->sections();
    check(count($sections['mainpages']->toArray()['data']) === 5, 'Editor lists exactly five main pages');
    check(count($sections['photos']->toArray()['data']) === 3, 'Editor exposes all three shared photographs');
    foreach ($sections as $section) check($section->errors() === [], 'Editor section resolves without errors');
    $editor = new Kirby\Cms\User(['id' => 'test-editor', 'email' => 'editor@example.test', 'role' => 'editor']);
    check($editor->role()->permissions()->for('access', 'system') === false, 'Content editor cannot access system settings');
    check($editor->role()->permissions()->for('access', 'users') === false, 'Content editor cannot manage other users');
    check($editor->role()->permissions()->for('site', 'update') === true, 'Content editor can update site content');
    new Kirby(['roots' => ['index' => dirname(__DIR__)], 'options' => ['ja' => ['inquiries' => $temp, 'local' => false, 'mail' => ['mode' => 'smtp', 'from' => '', 'to' => '', 'host' => '', 'username' => '', 'password' => '']]]]);
    $failedSafely = false;
    try { JitamaniInquiries::deliver($record); } catch (RuntimeException $e) { $failedSafely = true; }
    check($failedSafely && json_decode(file_get_contents($path), true)['state'] === 'pending', 'Unconfigured SMTP fails safely and preserves the pending inquiry');
    echo "\n$passed checks passed.\n";
} finally {
    if (is_dir($temp)) { foreach (glob($temp . '/*') as $file) unlink($file); foreach (glob($temp . '/.*') as $file) if (is_file($file)) unlink($file); rmdir($temp); }
}
