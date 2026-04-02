<?php
session_start();
<<<<<<< Updated upstream

if (isset($_SESSION['role'])) {
=======
if (isset($_SESSION['admin_id'])) {
    header('Location: index1.php');
    exit;
} else if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] === 'guest') {
        header('Location: ../guest%20user/home.php');
        exit;
    }

>>>>>>> Stashed changes
    if ($_SESSION['role'] === 'normal') {
        header('Location: ../Normal%20user/home.php');
        exit;
    }
<<<<<<< Updated upstream

    if ($_SESSION['role'] === 'admin') {
        header('Location: ../Admin%20dasbord/index1.php');
        exit;
    }
}
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$user = $_GET['user'] ?? '';
=======
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: Sign_in.php");
    exit;
}

require_once 'db.php';

$error = $_GET['error'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['admin_email'] ?? '');
    $password = $_POST['admin_password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, full_name, password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['role'] = 'admin'; // Compatibility with index1.php unified session check!
            header("Location: index1.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
$error = $_GET['error'] ?? '';
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
<body>
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="sign_in.php">My Bookings</a>
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
                <input type="hidden" name="origin" value="admin">
                <div class="options">
                    <label><input type="checkbox" name="remember_me"> Remember me</label>
                    <a href="../forgot_password.php">Forgot Password?</a>
=======
<body style="background: linear-gradient(165deg, var(--bg-top), var(--bg-bottom));">

<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="Sign_in.php?logout=true" class="active">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Logout / Sign In</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content" style="display: flex; justify-content: center; padding-top: 50px;">
        <div class="login-container" style="width: 100%; max-width: 450px;">
            <div class="login-box card" style="padding: 30px; border-radius: 14px; text-align: center;">
                <h2 class="section-title">Sign In</h2>
                <p style="color: var(--muted); margin-bottom: 24px;">Welcome back! Please login to your account</p>

                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form id="adminSignInForm" action="Sign_in.php" method="post" novalidate>
                    <div class="form-group" style="text-align: left;">
                        <input type="email" id="admin_email" name="admin_email" placeholder="Email Address" style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 4px; background: var(--surface-soft);" required>
                        <small class="error-message" style="margin-bottom: 12px;"></small>
                    </div>
                    
                    <div class="form-group" style="text-align: left;">
                        <input type="password" id="admin_password" name="admin_password" placeholder="Password" style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 4px; background: var(--surface-soft);" required>
                        <small class="error-message"></small>
                    </div>

                    <div class="options" style="display: flex; justify-content: space-between; margin: 16px 0; font-size: 14px; color: var(--muted);">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <a href="#" style="color: var(--accent-strong); text-decoration: none;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="submit-btn" style="width: 100%; margin-top: 10px;">Sign In</button>
                </form>

                <div class="divider" style="margin: 24px 0; color: #cbd5e1; font-weight: 600; font-size: 14px;">OR</div>

                <div class="social-login" style="display: flex; flex-direction: column; gap: 12px;">
                    <button class="google action-btn" style="background: white; color: var(--text); border: 1px solid var(--line); box-shadow: none;">Sign in with Google</button>
                    <button class="facebook action-btn" style="background: #1877f2; color: white;">Sign in with Facebook</button>
>>>>>>> Stashed changes
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
<script src="signin.js"></script>
</body>
</html>
