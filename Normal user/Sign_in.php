<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'normal') {
        header('Location: home.php');
        exit;
    }

    if ($_SESSION['role'] === 'guest') {
        header('Location: ../guest%20user/home.php');
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
    <title>Sign In | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="signin.css">
</head>
<body>
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="My_Bookings.php">My Bookings</a>
        <a href="sign_up.php">Sign Up</a>
    </nav>
</header>
<main class="auth-main">
    <div class="login-container">
        <div class="login-box">
            <h2>Sign In</h2>
            <p>Welcome back! Please login to your account</p>
            <?php if ($success !== ''): ?>
                <div class="error-box" style="display:block;background:#ecfdf5;color:#166534;border-color:#86efac;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form id="loginForm" action="../login.php" method="post" novalidate>
                <div id="loginErrors" class="error-box"<?php if ($error === ''): ?> style="display:none;"<?php endif; ?>><?= htmlspecialchars($error) ?></div>
                <input type="text" name="user_id" placeholder="User ID" value="<?= htmlspecialchars($user) ?>">
                <input type="password" name="password" placeholder="Password">
                <input type="hidden" name="origin" value="normal">
                <div class="options">
                    <label><input type="checkbox" name="remember_me"> Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit">Sign In</button>
            </form>
            <div class="divider">OR</div>
            <div class="social-login">
                <button class="google" onclick="googleLogin()">Sign in with Google</button>
                <button class="facebook" onclick="facebookLogin()">Sign in with Facebook</button>
            </div>
            <p class="signup-link">Don't have an account? <a href="sign_up.php">Sign Up</a></p>
        </div>
    </div>
</main>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div>
        <div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div>
        <div class="footer-col"><h4>Support</h4><a href="My_Bookings.php">My Bookings</a><a href="Sign_in.php">Sign In</a><a href="sign_up.php">Sign Up</a></div>
        <div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div>
    </div>
    <div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="sign-in.js"></script>
</body>
</html>
