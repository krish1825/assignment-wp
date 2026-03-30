<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: index1.php');
        exit;
    }

    if ($_SESSION['role'] === 'guest') {
        header('Location: ../guest%20user/home.php');
        exit;
    }

    if ($_SESSION['role'] === 'normal') {
        header('Location: ../Normal%20user/home.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Ticketvarse</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Sign In</h2>
        <p>Welcome back! Please login to your account</p>

        <form id="loginForm" action="../login.php" method="post" novalidate>
            <div id="loginErrors" class="error-box"<?php if (!isset($_GET['error'])): ?> style="display:none;"<?php endif; ?>>
                <?php if (isset($_GET['error'])): ?>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                <?php endif; ?>
            </div>
            <input type="text" name="user_id" placeholder="User ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="hidden" name="origin" value="admin">

            <div class="options">
                <label>
                    <input type="checkbox"> Remember me
                </label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit">Sign In</button>
        </form>

        <div class="divider">OR</div>

        <div class="social-login">
            <button class="google">Sign in with Google</button>
            <button class="facebook">Sign in with Facebook</button>
        </div>

        <p class="signup-link">
            Don't have an account? <a href="sign_up.php">Sign Up</a>
        </p>
    </div>
</div>

<script src="signin.js"></script>
</body>
</html>
