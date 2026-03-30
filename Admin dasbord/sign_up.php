<?php
require_once 'db.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $phone = trim($_POST['admin_phone']);
    $password = $_POST['admin_password'];
    $confirm = $_POST['admin_password_confirm'];

    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admins (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $phone, $hashed_password])) {
                $success = "Registration successful! You can now sign in.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | TicketVerse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="signin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: linear-gradient(165deg, var(--bg-top), var(--bg-bottom));">

<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php" class="active">Login</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Sign Up</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content" style="display: flex; justify-content: center; padding-top: 50px;">
        <div class="login-container" style="width: 100%; max-width: 450px;">
            <div class="login-box card" style="padding: 30px; border-radius: 14px; text-align: center;">
                <h2 class="section-title">Admin Registration</h2>
                <p style="color: var(--muted); margin-bottom: 24px;">Create a new administrator account</p>

                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form action="sign_up.php" method="post" novalidate>
                    <div class="form-group" style="text-align: left;">
                        <input type="text" name="admin_name" placeholder="Full Name" required style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; background: var(--surface-soft);">
                    </div>
                    
                    <div class="form-group" style="text-align: left;">
                        <input type="email" name="admin_email" placeholder="Email Address" required style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; background: var(--surface-soft);">
                    </div>

                    <div class="form-group" style="text-align: left;">
                        <input type="tel" name="admin_phone" placeholder="Phone Number" required style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; background: var(--surface-soft);">
                    </div>

                    <div class="form-group" style="text-align: left;">
                        <input type="password" name="admin_password" placeholder="Password" required style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; background: var(--surface-soft);">
                    </div>

                    <div class="form-group" style="text-align: left;">
                        <input type="password" name="admin_password_confirm" placeholder="Confirm Password" required style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; background: var(--surface-soft);">
                    </div>

                    <button type="submit" class="submit-btn" style="width: 100%; margin-top: 10px;">Sign Up</button>
                </form>

                <p class="signup-link" style="margin-top: 24px; color: var(--muted); font-size: 14px;">
                    Already have an account? <a href="sign_in.php" style="color: var(--accent-strong); text-decoration: none; font-weight: 600;">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="script.js"></script>
</body>
</html>
