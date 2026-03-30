<?php
session_start();

require_once __DIR__ . '/../includes/content_repository.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'normal') {
    header('Location: Sign_in.php?error=Please%20sign%20in%20as%20normal%20user');
    exit;
}

$user = find_user_for_login((string) ($_SESSION['user_id'] ?? ''));
if (!$user || ($user['status'] ?? 'active') !== 'active') {
    session_unset();
    session_destroy();
    header('Location: Sign_in.php?error=Your%20account%20is%20inactive');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'profile') {
        update_user_profile((int) $user['id'], [
            'full_name' => $_POST['full_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'country' => $_POST['country'] ?? '',
            'interests' => $_POST['interests'] ?? '',
            'bio' => $_POST['bio'] ?? '',
        ]);
        header('Location: profile.php?message=profile-saved');
        exit;
    }

    if ($action === 'payment_method') {
        $methodType = trim((string) ($_POST['method_type'] ?? ''));
        $label = trim((string) ($_POST['label'] ?? ''));
        $details = trim((string) ($_POST['details'] ?? ''));

        if ($methodType !== '' && $label !== '') {
            save_payment_method((int) $user['id'], $methodType, $label, $details, isset($_POST['is_default']));
        }

        header('Location: profile.php?message=payment-saved#payments');
        exit;
    }
}

$user = find_user_for_login((string) ($_SESSION['user_id'] ?? ''));
$bookings = fetch_user_bookings((int) $user['id']);
$paymentMethods = fetch_user_payment_methods((int) $user['id']);
$message = $_GET['message'] ?? '';
$upcomingBookings = array_filter($bookings, static fn(array $booking): bool => strtotime((string) $booking['booking_date']) >= strtotime(date('Y-m-d')));
$interestItems = array_values(array_filter(array_map('trim', explode(',', (string) ($user['interests'] ?? '')))));
$avatar = strtoupper(substr((string) ($user['full_name'] ?? 'U'), 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="profile.php">Profile</a>
        <a href="My_Bookings.php">My Bookings</a>
    </nav>
</header>
<div class="profile-shell">
    <section class="profile-hero">
        <div class="profile-card">
            <div class="avatar"><?= e($avatar) ?></div>
            <div class="profile-meta">
                <p class="eyebrow">Normal User</p>
                <h1><?= e($user['full_name']) ?></h1>
                <p class="subtitle">Member since <?= e(date('Y', strtotime((string) $user['created_at']))) ?><?= !empty($user['country']) ? ' - ' . e($user['country']) : '' ?></p>
                <div class="profile-actions">
                    <button class="btn" type="button" onclick="document.getElementById('edit-profile').scrollIntoView({behavior:'smooth'});">Edit Profile</button>
                    <button class="ghost-btn" type="button" onclick="document.getElementById('payments').scrollIntoView({behavior:'smooth'});">Manage Payments</button>
                </div>
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat-card"><h3><?= count($bookings) ?></h3><p>Bookings</p></div>
            <div class="stat-card"><h3><?= count($paymentMethods) ?></h3><p>Saved Payments</p></div>
            <div class="stat-card"><h3><?= count($upcomingBookings) ?></h3><p>Upcoming Shows</p></div>
        </div>
    </section>

    <?php if ($message === 'profile-saved'): ?>
        <div style="margin-bottom:16px;padding:12px 14px;border-radius:10px;background:#ecfdf5;border:1px solid #86efac;color:#166534;font-weight:600;">Profile updated successfully.</div>
    <?php elseif ($message === 'payment-saved'): ?>
        <div style="margin-bottom:16px;padding:12px 14px;border-radius:10px;background:#ecfdf5;border:1px solid #86efac;color:#166534;font-weight:600;">Payment method saved successfully.</div>
    <?php endif; ?>

    <section class="profile-grid">
        <div class="info-card" id="edit-profile">
            <h2>Personal Details</h2>
            <form class="profile-form" method="post">
                <input type="hidden" name="action" value="profile">
                <div class="form-row">
                    <div class="form-group"><label for="full_name">Full Name</label><input id="full_name" name="full_name" type="text" value="<?= e($user['full_name']) ?>"></div>
                    <div class="form-group"><label for="email">Email</label><input id="email" name="email" type="email" value="<?= e($user['email']) ?>"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label for="phone">Phone</label><input id="phone" name="phone" type="tel" value="<?= e($user['phone'] ?? '') ?>"></div>
                    <div class="form-group"><label for="country">Country</label><input id="country" name="country" type="text" value="<?= e($user['country'] ?? '') ?>"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label for="dob">Date of Birth</label><input id="dob" name="dob" type="date" value="<?= e($user['dob'] ?? '') ?>"></div>
                    <div class="form-group"><label for="gender">Gender</label><input id="gender" name="gender" type="text" value="<?= e($user['gender'] ?? '') ?>"></div>
                </div>
                <div class="form-row"><div class="form-group full"><label for="interests">Interests</label><input id="interests" name="interests" type="text" value="<?= e($user['interests'] ?? '') ?>" placeholder="Drama, Action, Concerts"></div></div>
                <div class="form-row"><div class="form-group full"><label for="bio">Bio</label><textarea id="bio" name="bio" rows="3"><?= e($user['bio'] ?? '') ?></textarea></div></div>
                <div class="form-row"><button class="btn" type="submit">Save Changes</button></div>
            </form>
        </div>

        <div class="info-card">
            <h2>Preferences</h2>
            <div class="pill-group">
                <?php if ($interestItems === []): ?><span>No preferences saved</span><?php else: ?><?php foreach ($interestItems as $interest): ?><span><?= e($interest) ?></span><?php endforeach; ?><?php endif; ?>
            </div>
            <div class="divider"></div>
            <h3>Notifications</h3>
            <ul class="list">
                <li>Email: <?= !empty($user['email']) ? 'Enabled' : 'Not set' ?></li>
                <li>Phone alerts: <?= !empty($user['phone']) ? 'Enabled' : 'Not set' ?></li>
                <li>Account status: <?= e(ucfirst((string) $user['status'])) ?></li>
            </ul>
        </div>

        <div class="info-card">
            <h2>Upcoming Bookings</h2>
            <?php if ($bookings === []): ?>
                <p class="muted">No bookings yet. Your confirmed tickets will appear here.</p>
            <?php else: ?>
                <?php foreach (array_slice($bookings, 0, 3) as $booking): ?>
                    <div class="booking-item">
                        <div><h4><?= e($booking['show_name']) ?></h4><p><?= e(date('M d, Y', strtotime((string) $booking['booking_date']))) ?> - <?= e($booking['booking_time']) ?> - <?= e($booking['city'] ?: $booking['venue']) ?></p></div>
                        <span class="booking-chip"><?= e(ucfirst((string) $booking['booking_status'])) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="info-card" id="payments">
            <h2>Manage Payments</h2>
            <?php if ($paymentMethods === []): ?>
                <p class="muted">No saved payment methods yet.</p>
            <?php else: ?>
                <?php foreach ($paymentMethods as $method): ?>
                    <div class="security-row">
                        <div><h4><?= e($method['label']) ?><?= (int) $method['is_default'] === 1 ? ' (Default)' : '' ?></h4><p><?= e($method['details'] ?? '') ?></p></div>
                        <button class="ghost-btn" type="button"><?= e(ucfirst((string) $method['method_type'])) ?></button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="divider"></div>
            <form method="post" class="profile-form">
                <input type="hidden" name="action" value="payment_method">
                <div class="form-row">
                    <div class="form-group"><label for="method_type">Method Type</label><input id="method_type" name="method_type" type="text" placeholder="card / upi / wallet"></div>
                    <div class="form-group"><label for="label">Label</label><input id="label" name="label" type="text" placeholder="HDFC Visa ending 4242"></div>
                </div>
                <div class="form-row"><div class="form-group full"><label for="details">Details</label><input id="details" name="details" type="text" placeholder="Saved for faster checkout"></div></div>
                <div class="form-row"><label style="display:flex;align-items:center;gap:8px;color:#475569;"><input type="checkbox" name="is_default" value="1" style="width:auto;"> Set as default</label></div>
                <div class="form-row"><button class="btn" type="submit">Save Payment Method</button></div>
            </form>
        </div>
    </section>
</div>
<footer class="site-footer"><div class="footer-grid"><div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div><div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div><div class="footer-col"><h4>Support</h4><a href="profile.php">Profile</a><a href="My_Bookings.php">My Bookings</a><a href="sign_up.php">Sign Up</a></div><div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div></div><div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div></footer>
</body>
</html>
