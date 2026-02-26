<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Ticketvarse</title>
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
    <a href="sign_in.php" class="active">Logout</a>
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

                <form id="adminSignInForm" action="index.php" method="post" novalidate>
                    <div class="form-group" style="text-align: left;">
                        <input type="email" id="admin_email" name="admin_email" placeholder="Email Address" style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 4px; background: var(--surface-soft);">
                        <small class="error-message" style="margin-bottom: 12px;"></small>
                    </div>
                    
                    <div class="form-group" style="text-align: left;">
                        <input type="password" id="admin_password" name="admin_password" placeholder="Password" style="width: 100%; border: 1px solid #bfd8ff; border-radius: 8px; padding: 10px 12px; margin-bottom: 4px; background: var(--surface-soft);">
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
                </div>

                <p class="signup-link" style="margin-top: 24px; color: var(--muted); font-size: 14px;">
                    Don't have an account? <a href="sign_up.php" style="color: var(--accent-strong); text-decoration: none; font-weight: 600;">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="script.js"></script>
<script src="signin.js"></script>
</body>
</html>
