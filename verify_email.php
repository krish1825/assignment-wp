<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content_repository.php';

$token = trim((string) ($_GET['token'] ?? ''));

if ($token === '') {
    header('Location: guest%20user/Sign_in.php?error=' . rawurlencode('Verification link is missing or invalid.'));
    exit;
}

$user = find_user_by_verification_token($token);

if ($user === null) {
    header('Location: guest%20user/Sign_in.php?error=' . rawurlencode('Verification link is invalid or expired. Request a new verification email.'));
    exit;
}

mark_user_email_verified((int) $user['id']);

header('Location: guest%20user/Sign_in.php?success=' . rawurlencode('Email verified successfully. You can sign in now.') . '&user=' . rawurlencode((string) $user['user_id']));
exit;
