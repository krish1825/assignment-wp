<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'normal') {
        header('Location: ../Normal%20user/home.php');
        exit;
    }

    if ($_SESSION['role'] === 'admin') {
        header('Location: ../Admin%20dasbord/index1.php');
        exit;
    }
}
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$user = $_GET['user'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="signin.css">
</head>
<body class="admin-auth-body">
<div class="admin-auth-shell">
<header class="admin-auth-header">
    <div class="admin-auth-brand">
        <strong>Ticketvarse Admin</strong>
        <span>Dashboard access for administrators only</span>
    </div>
    <div class="admin-auth-links">
        <!-- <a href="sign_up.php">Create Admin</a> -->
        <a href="../guest%20user/Sign_in.php" class="primary-link">User Sign In</a>
    </div>
</header>
<main class="auth-main">
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Sign In</h2>
            <p>Welcome back. Sign in to manage Ticketvarse operations.</p>
            <?php if ($success !== ''): ?>
                <div class="error-box" style="display:block;background:#ecfdf5;color:#166534;border-color:#86efac;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form id="loginForm" action="../login.php" method="post" novalidate>
                <div id="loginErrors" class="error-box"<?php if ($error === ''): ?> style="display:none;"<?php endif; ?>><?= htmlspecialchars($error) ?></div>
                <input type="text" name="user_id" placeholder="User ID" value="<?= htmlspecialchars($user) ?>">
                <input type="password" name="password" placeholder="Password">
                <input type="hidden" name="origin" value="admin">
                <div class="options">
                    <label><input type="checkbox" name="remember_me"> Remember me</label>
                    <a href="../forgot_password.php">Forgot Password?</a>
                </div>
                <button type="submit">Sign In</button>
            </form>
            <form action="../resend_verification.php" method="post" style="margin-top:12px;">
                <input type="hidden" name="origin" value="admin">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user) ?>">
                <button type="submit" style="width:100%;background:#111827;color:#fff;border:none;padding:12px;border-radius:8px;cursor:pointer;">Resend Verification Email</button>
            </form>
            <div class="divider">OR</div>
            <div class="social-login">
                <button class="google" onclick="googleLogin()">Sign in with Google</button>
                <button class="facebook" onclick="facebookLogin()">Sign in with Facebook</button>
            </div>
            <p class="signup-link">Need a new admin account? <a href="sign_up.php">Sign Up</a></p>
            <p class="auth-note">Use administrator credentials here. Regular users should sign in through the public app.</p>
        </div>
    </div>
</main>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="../assets/js/form-validation.js"></script>
<script src="signin.js"></script>
</body>
</html>
