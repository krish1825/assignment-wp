<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/content_repository.php';

$error = '';
$success = '';
$identifier = trim((string) ($_POST['identifier'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($identifier === '') {
        $error = 'Enter your user ID or email address.';
    } else {
        $user = find_user_by_identifier($identifier);
        if ($user === null) {
            $success = 'If your account exists, a password reset link has been created and logged.';
            $identifier = '';
        } else {
            $token = bin2hex(random_bytes(16));
            $tokenHash = hash('sha256', $token);
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);
            $created = create_password_reset_request((int) $user['id'], $tokenHash, $expiresAt);

            if ($created) {
                $resetUrl = ticketvarse_app_url() . '/reset_password.php?token=' . rawurlencode($token);
                ticketvarse_send_password_reset_mail((string) $user['email'], $resetUrl);
                $success = 'Password reset link created. Check your email or storage/mail/password_reset.log for the link.';
                $identifier = '';
            } else {
                $error = 'Unable to create the password reset request. Please try again later.';
            }
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Ticketvarse</title>
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
            <h2>Forgot Password</h2>
            <p>Enter your user ID or email address to receive a password reset link.</p>
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

            <form action="forgot_password.php" method="post" novalidate>
                <input type="text" name="identifier" placeholder="User ID or Email" value="<?= htmlspecialchars($identifier) ?>">
                <button type="submit">Send Reset Link</button>
            </form>
            <p style="margin-top:16px; font-size:0.95rem;">
                <a href="guest user/Sign_in.php">Back to Sign In</a>
            </p>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>
</body>
</html>
