<?php
declare(strict_types=1);

return function ($kirby, $site, $page) {
    $errors = []; $errorStatus = 422; $values = ['name' => '', 'email' => '', 'phone' => '', 'interest' => '', 'message' => ''];
    $interest = get('interest', '');
    if (is_string($interest) && array_key_exists($interest, JitamaniInquiries::interests())) $values['interest'] = $interest;
    $success = $kirby->session()->pull('ja.inquiry.success');
    if (option('ja.demo')) {
        // A disposable review deployment must not collect or email inquiries.
        if ($kirby->request()->is('POST')) $kirby->response()->code(405);
        $success = null;
        return compact('errors', 'values', 'success');
    }
    if ($kirby->request()->is('POST')) {
        $kirby->response()->header('Cache-Control', 'no-store, private', true);
        foreach ($values as $key => $_) $values[$key] = is_string(get($key)) ? trim(get($key)) : '';
        if (!is_string(get('csrf')) || !csrf(get('csrf'))) {
            $errors['form'] = 'This form has expired. Please refresh the page and try again.';
            $errorStatus = 403;
        } elseif (get('website', '') !== '') {
            // Quietly discard honeypot submissions without storing or sending them.
            $kirby->session()->set('ja.inquiry.success', ['local' => (bool)option('ja.local')]);
            go($page->url() . '#inquiry');
        } else {
            $errors = JitamaniInquiries::validate($values);
            if (!$errors) {
                try {
                    if (!JitamaniInquiries::rateLimit($_SERVER['REMOTE_ADDR'] ?? 'unknown')) {
                        $errors['form'] = 'A few messages have already been sent. Please try later, or contact us by email or WhatsApp.';
                        $errorStatus = 429;
                    } else {
                        $record = array_merge($values, ['id' => bin2hex(random_bytes(10)), 'created' => gmdate('c'), 'state' => 'pending']);
                        JitamaniInquiries::save($record);
                        try {
                            JitamaniInquiries::deliver($record);
                            $record['state'] = option('ja.local') ? 'local-test' : 'sent';
                            JitamaniInquiries::save($record);
                            $kirby->session()->set('ja.inquiry.success', ['id' => $record['id'], 'local' => (bool)option('ja.local')]);
                            go($page->url() . '#inquiry');
                        } catch (Throwable $e) {
                            error_log('Jitamani mail delivery requires attention; inquiry ' . $record['id']);
                            $errors['form'] = 'Your message was saved, but we could not confirm email delivery. Please reach us by email or WhatsApp. Your reference is ' . $record['id'] . '.';
                            $errorStatus = 503;
                        }
                    }
                } catch (Throwable $e) {
                    error_log('Jitamani inquiry storage requires attention.');
                    $errors['form'] = 'We could not send your message. Please try again, or reach us by email or WhatsApp.';
                    $errorStatus = 503;
                }
            }
        }
        if ($errors) $kirby->response()->code($errorStatus);
    }
    return compact('errors', 'values', 'success');
};
