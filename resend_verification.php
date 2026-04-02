<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content_repository.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: guest%20user/Sign_in.php');
    exit;
}

$identifier = trim((string) ($_POST['user_id'] ?? ''));
$origin = trim((string) ($_POST['origin'] ?? 'guest'));

$fallback = 'guest%20user/Sign_in.php';
if ($origin === 'admin') {
    $fallback = 'Admin%20dasbord/Sign_in.php';
} elseif ($origin === 'normal') {
    $fallback = 'Normal%20user/Sign_in.php';
}

if ($identifier === '') {
    header('Location: ' . $fallback . '?error=' . rawurlencode('Enter your user ID to resend the verification email.'));
    exit;
}

$user = find_user_for_login($identifier);

if ($user === null) {
    header('Location: ' . $fallback . '?error=' . rawurlencode('User ID not found.') . '&user=' . rawurlencode($identifier));
    exit;
}

if (is_user_email_verified($user)) {
    header('Location: ' . $fallback . '?success=' . rawurlencode('This email is already verified. You can sign in now.') . '&user=' . rawurlencode((string) $user['user_id']));
    exit;
}

send_verification_for_user($user);
$message = 'Verification email sent. A copy of the verification link was saved to storage/mail/verification.log for local testing.';

header('Location: ' . $fallback . '?success=' . rawurlencode($message) . '&user=' . rawurlencode((string) $user['user_id']));
exit;
