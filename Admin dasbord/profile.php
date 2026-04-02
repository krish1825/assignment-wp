<?php


declare(strict_types=1);

require_once 'session_check.php';
require_once __DIR__ . '/../includes/content_repository.php';

$loginUserId = trim((string) ($_SESSION['user_id'] ?? ''));
$admin_id = $_SESSION['admin_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$success = '';
$message = trim((string) ($_GET['message'] ?? ''));
$success = $message === 'profile-updated' ? 'Profile updated successfully!' : '';

$error = '';

if ($loginUserId === '') {
    header('Location: Sign_in.php?error=Please%20sign%20in%20again');
    exit;
}

$admin = find_user_for_login($loginUserId);
if (!$admin || (($admin['role'] ?? '') !== 'admin')) {
    header('Location: Sign_in.php?error=Admin%20account%20not%20found');
    exit;
}

$adminId = (int) $admin['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['admin_name'] ?? ''));
    $email = trim((string) ($_POST['admin_email'] ?? ''));
    $phone = trim((string) ($_POST['admin_phone'] ?? ''));
    $bio = trim((string) ($_POST['admin_bio'] ?? ''));
    $name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $phone = trim($_POST['admin_phone']);
    $bio = trim($_POST['admin_bio'] ?? '');
    
    if ($name === '' || $email === '' || $phone === '') {
        $error = 'Name, email, and phone are required.';
    } else {
        try {
            update_user_profile($adminId, [
                'full_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'dob' => $admin['dob'] ?? null,
                'gender' => $admin['gender'] ?? null,
                'country' => $admin['country'] ?? null,
                'interests' => $admin['interests'] ?? null,
                'bio' => $bio,
            ]);
            header('Location: profile.php?message=profile-updated');
            exit;
        } catch (Throwable $exception) {
            $error = 'Failed to update profile.';
        if ($admin_id) {
            $stmt = $conn->prepare("UPDATE admins SET full_name = ?, email = ?, phone = ?, bio = ? WHERE id = ?");
            if ($stmt->execute([$name, $email, $phone, $bio, $admin_id])) {
                $success = "Profile updated successfully!";
                $_SESSION['admin_name'] = $name;
            } else {
                $error = "Failed to update profile.";
            }
        } else if ($user_id) {
            require_once '../config/database.php';
            $main_db = ticketvarse_db();
            $stmt = $main_db->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, bio = ? WHERE user_id = ?");
            if ($stmt->execute([$name, $email, $phone, $bio, $user_id])) {
                $success = "Profile updated successfully!";
            } else {
                $error = "Failed to update profile.";
            }
        }
    }
}

$admin = false;
if ($admin_id) {
    $stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} else if ($user_id) {
    require_once '../config/database.php';
    $main_db = ticketvarse_db();
    $stmt = $main_db->prepare("SELECT *, full_name, email, phone, bio FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$admin) {
    $admin = ['full_name' => 'Admin User', 'email' => '', 'phone' => '', 'bio' => ''];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Profile</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">TicketVerse</div>
        <a href="index1.php">Dashboard</a>
        <a href="events.php">Manage Events</a>
        <a href="bookings.php">Bookings</a>
        <a href="users.php">Users</a>
        <a href="profile.php" class="active">Profile</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>
            <h3>Admin Profile</h3>
            <a class="profile-btn" href="profile.php">Admin Profile</a>
        </div>

        <div class="page-content">
            <div class="page-intro">
                <div>
                    <h1>Profile Settings</h1>
                    <p>Keep your administrator contact details up to date.</p>
                </div>
            </div>
            <div class="profile-layout">
                <div class="profile-card">
                    <div class="profile-avatar"><?php echo htmlspecialchars(strtoupper(substr((string) ($admin['full_name'] ?? 'A'), 0, 1))); ?></div>
                    <h2><?php echo htmlspecialchars($admin['full_name']); ?></h2>
                    <p>Super Admin</p>
                    <span class="profile-badge">Active</span>
                </div>

                <form class="form-card profile-form" id="profileForm" action="profile.php" method="post" novalidate>
                    <h2 class="section-title">Profile Details</h2>
                    
                    <?php if ($error): ?>
                        <div class="notice-card">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="notice-card success">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="admin_name">Full Name</label>
                            <input type="text" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($admin['full_name']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Email</label>
                            <input type="email" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($admin['email']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_phone">Phone</label>
                            <input type="tel" id="admin_phone" name="admin_phone" value="<?php echo htmlspecialchars($admin['phone']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_role">Role</label>
                            <input type="text" id="admin_role" name="admin_role" value="Super Admin" readonly>
                        </div>
                        <div class="form-group full-width">
                            <label for="admin_bio">Bio</label>
                            <textarea id="admin_bio" name="admin_bio" placeholder="Write a short profile bio"><?php echo htmlspecialchars($admin['bio'] ?? ''); ?></textarea>
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group full-width">
                            <button type="submit" class="submit-btn">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
    <script src="../assets/js/form-validation.js"></script>
    <script src="script.js"></script>

</body>

</html>