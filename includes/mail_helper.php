<?php

declare(strict_types=1);

function ticketvarse_app_url(): string
{
    $configured = trim((string) getenv('APP_URL'));
    if ($configured !== '') {
        return rtrim($configured, '/');
    }

    $host = trim((string) ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    $https = $_SERVER['HTTPS'] ?? '';
    $scheme = ($https !== '' && $https !== 'off') ? 'https' : 'http';
    $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDirectory = str_replace('\\', '/', dirname($scriptName));
    if ($scriptDirectory === '.' || $scriptDirectory === '/' || $scriptDirectory === '\\') {
        $scriptDirectory = '';
    } else {
        $scriptDirectory = rtrim($scriptDirectory, '/');
    }

    return $scheme . '://' . $host . $scriptDirectory;
}

function ticketvarse_mail_log_path(): string
{
    return dirname(__DIR__) . '/storage/mail/verification.log';
}

function ticketvarse_log_mail_message(string $recipient, string $subject, string $body): void
{
    $path = ticketvarse_mail_log_path();
    $directory = dirname($path);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $entry = sprintf(
        "[%s]\nTo: %s\nSubject: %s\n%s\n\n",
        date('Y-m-d H:i:s'),
        $recipient,
        $subject,
        $body
    );
    file_put_contents($path, $entry, FILE_APPEND);
}

function ticketvarse_send_mail(string $to, string $subject, string $body): array
{
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/plain; charset=UTF-8',
        'From: Ticketvarse <no-reply@ticketvarse.local>',
    ];

    $sent = false;
    if (function_exists('mail')) {
        $sent = @mail($to, $subject, $body, implode("\r\n", $headers));
    }

    ticketvarse_log_mail_message($to, $subject, $body);

    return [
        'sent' => $sent,
        'logged' => true,
        'log_path' => ticketvarse_mail_log_path(),
    ];
}

function ticketvarse_password_reset_log_path(): string
{
    return dirname(__DIR__) . '/storage/mail/password_reset.log';
}

function ticketvarse_log_password_reset_message(string $recipient, string $subject, string $body): void
{
    $path = ticketvarse_password_reset_log_path();
    $directory = dirname($path);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $entry = sprintf(
        "[%s]\nTo: %s\nSubject: %s\n%s\n\n",
        date('Y-m-d H:i:s'),
        $recipient,
        $subject,
        $body
    );
    file_put_contents($path, $entry, FILE_APPEND);
}

function ticketvarse_send_password_reset_mail(string $to, string $resetUrl): array
{
    $subject = 'Ticketvarse password reset request';
    $body = "A password reset request was received for your account.\n\nUse the link below to reset your password:\n\n{$resetUrl}\n\nThis link will expire in 60 minutes. If you did not request a password reset, ignore this message.";

    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/plain; charset=UTF-8',
        'From: Ticketvarse <no-reply@ticketvarse.local>',
    ];

    $sent = false;
    if (function_exists('mail')) {
        $sent = @mail($to, $subject, $body, implode("\r\n", $headers));
    }

    ticketvarse_log_password_reset_message($to, $subject, $body);

    return [
        'sent' => $sent,
        'logged' => true,
        'log_path' => ticketvarse_password_reset_log_path(),
    ];
}
