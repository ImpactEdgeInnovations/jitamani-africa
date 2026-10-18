<?php
declare(strict_types=1);

final class JitamaniInquiries
{
    public static function validate(array $input): array
    {
        $errors = [];
        if (mb_strlen($input['name'] ?? '') < 2 || mb_strlen($input['name'] ?? '') > 120) $errors['name'] = 'Please enter your name (2–120 characters).';
        if (!filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL) || strlen($input['email'] ?? '') > 254) $errors['email'] = 'Please enter a valid email address.';
        if (mb_strlen($input['phone'] ?? '') > 40 || preg_match('/[\r\n]/', $input['phone'] ?? '')) $errors['phone'] = 'Please check your phone number.';
        if (mb_strlen($input['message'] ?? '') < 10 || mb_strlen($input['message'] ?? '') > 5000) $errors['message'] = 'Please tell us a little more (10–5,000 characters).';
        return $errors;
    }

    public static function directory(): string
    {
        $directory = option('ja.inquiries');
        if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) throw new RuntimeException('Private storage unavailable');
        if (!is_writable($directory)) throw new RuntimeException('Private storage unavailable');
        return $directory;
    }

    public static function rateLimit(string $ip): bool
    {
        $directory = self::directory();
        // IP never written to disk; filename is an opaque hash with private site-specific salt.
        $saltPath = $directory . '/.salt';
        if (!is_file($saltPath)) {
            $handle = @fopen($saltPath, 'x');
            if ($handle) { chmod($saltPath, 0600); fwrite($handle, bin2hex(random_bytes(32))); fclose($handle); }
        }
        $salt = file_get_contents($saltPath);
        if (!$salt) throw new RuntimeException('Rate limit unavailable');
        $file = $directory . '/rate-' . hash_hmac('sha256', $ip, $salt) . '.json';
        $handle = fopen($file, 'c+');
        if (!$handle || !flock($handle, LOCK_EX)) throw new RuntimeException('Rate limit unavailable');
        chmod($file, 0600);
        $state = json_decode(stream_get_contents($handle), true) ?: ['since' => time(), 'count' => 0];
        if (time() - $state['since'] >= 900) $state = ['since' => time(), 'count' => 0];
        $allowed = $state['count'] < 5;
        $state['count']++;
        rewind($handle); ftruncate($handle, 0); fwrite($handle, json_encode($state)); fflush($handle); flock($handle, LOCK_UN); fclose($handle);
        return $allowed;
    }

    public static function save(array $record): string
    {
        $path = self::directory() . '/inquiry-' . $record['id'] . '.json';
        $temp = $path . '.' . bin2hex(random_bytes(4)) . '.tmp';
        if (file_put_contents($temp, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), LOCK_EX) === false) throw new RuntimeException('Inquiry could not be saved');
        chmod($temp, 0600);
        if (!rename($temp, $path)) throw new RuntimeException('Inquiry could not be saved');
        return $path;
    }

    public static function deliver(array $record): void
    {
        $mail = option('ja.mail');
        if (($mail['mode'] ?? '') === 'log' && option('ja.local')) return;
        foreach (['from', 'to', 'host', 'username', 'password'] as $key) if (empty($mail[$key])) throw new RuntimeException('Mail is not configured');
        kirby()->email([
            'from' => $mail['from'], 'to' => $mail['to'], 'replyTo' => $record['email'],
            'subject' => 'Website inquiry · ' . $record['id'],
            'body' => ['text' => "Name: {$record['name']}\nEmail: {$record['email']}\nPhone: {$record['phone']}\n\n{$record['message']}\n\nReference: {$record['id']}"],
            'transport' => ['type' => 'smtp', 'host' => $mail['host'], 'port' => $mail['port'], 'security' => $mail['security'], 'auth' => true, 'username' => $mail['username'], 'password' => $mail['password']],
        ]);
    }
}
