<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/content_repository.php';

$error = '';
$success = '';
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$password = trim((string) ($_POST['password'] ?? ''));
$confirmPassword = trim((string) ($_POST['confirm_password'] ?? ''));
$reset = null;

if ($token !== '') {
    $reset = find_password_reset_by_token($token);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($token === '') {
        $error = 'Invalid password reset link.';
    } elseif ($reset === null) {
        $error = 'This password reset link is invalid or has expired.';
    } elseif ($password === '' || $confirmPassword === '') {
        $error = 'Enter and confirm your new password.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } else {
        $updated = update_user_password((int) $reset['user_id'], $password);
        if ($updated) {
            mark_password_reset_as_used((int) $reset['id']);
            $success = 'Your password has been reset successfully. You may now sign in.';
            $reset = null;
            $password = $confirmPassword = '';
        } else {
            $error = 'Unable to update your password. Please try again.';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Ticketvarse</title>
    <link rel="stylesheet" href="guest user/style.css">
    <link rel="stylesheet" href="guest user/signin.css">
</head>
<body>
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="guest user/home.php">Home</a>
        <a href="guest user/movies.php">Movies</a>
        <a href="guest user/events.php">Events</a>
        <a href="guest user/Offers.php">Offers</a>
        <a href="guest user/Sign_in.php">Sign In</a>
        <a href="guest user/sign_up.php">Sign Up</a>
    </nav>
</header>
<main class="auth-main">
    <div class="login-container">
        <div class="login-box">
            <h2>Reset Password</h2>
            <?php if ($success !== ''): ?>
                <div class="error-box" style="display:block;background:#ecfdf5;color:#166534;border-color:#86efac;">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            <?php if ($error !== ''): ?>
                <div class="error-box" style="display:block;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success === '' && $reset !== null): ?>
                <p>Enter your new password for <strong><?= htmlspecialchars($reset['user_login_id']) ?></strong>.</p>
                <form action="reset_password.php" method="post" novalidate>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <input type="password" name="password" placeholder="New Password" value="<?= htmlspecialchars($password) ?>">
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" value="<?= htmlspecialchars($confirmPassword) ?>">
                    <button type="submit">Reset Password</button>
                </form>
            <?php elseif ($success === '' && $reset === null): ?>
                <p>This password reset link is invalid or expired.</p>
                <p><a href="forgot_password.php">Request a new password reset</a></p>
            <?php endif; ?>
            <p style="margin-top:16px; font-size:0.95rem;"><a href="guest user/Sign_in.php">Back to Sign In</a></p>
        </div>
    </div>
</main>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div>
        <div class="footer-col"><h4>Quick Links</h4><a href="guest user/home.php">Home</a><a href="guest user/movies.php">Movies</a><a href="guest user/events.php">Events</a><a href="guest user/Offers.php">Offers</a></div>
        <div class="footer-col"><h4>Support</h4><a href="guest user/Sign_in.php">Sign In</a><a href="guest user/sign_up.php">Sign Up</a></div>
        <div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div>
    </div>
    <div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div>
</footer>
</body>
</html>
