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

$bookings = fetch_user_bookings((int) $user['id']);
$success = trim((string) ($_GET['success'] ?? ''));
$bookingId = (int) ($_GET['booking_id'] ?? 0);
if ($success !== '' && $bookingId > 0) {
    $success .= ' Booking ID: #' . $bookingId;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="my-bookings.css">
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
<section class="bookings-page">
    <h1>My Bookings</h1>
    <p>Track all your movie and event bookings in one place.</p>
    <?php if ($success !== ''): ?><div style="margin-bottom:16px;padding:12px 14px;border-radius:10px;background:#ecfdf5;border:1px solid #86efac;color:#166534;font-weight:600;"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <div class="bookings-grid">
        <?php if ($bookings === []): ?>
            <div class="booking-card"><h3>No bookings yet</h3><p class="booking-meta">Your confirmed movie and event tickets will appear here after payment.</p></div>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card searchable-card" data-search="<?= e(strtolower($booking['show_name'] . ' ' . $booking['venue'] . ' ' . $booking['seats'])) ?>">
                    <span class="booking-type"><?= e(ucfirst((string) $booking['booking_type'])) ?></span>
                    <h3><?= e($booking['show_name']) ?></h3>
                    <p class="booking-meta">Booking ID: #<?= (int) $booking['id'] ?><br>Date: <?= e(date('d M Y', strtotime((string) $booking['booking_date']))) ?><br>Time: <?= e($booking['booking_time']) ?><br>Venue: <?= e($booking['venue']) ?><br>Seats: <?= e($booking['seats']) ?><br>Amount: INR <?= number_format((float) $booking['total_amount'], 0) ?></p>
                    <span class="status <?= e(strtolower((string) $booking['booking_status'])) ?>"><?= e(ucfirst((string) $booking['booking_status'])) ?></span>
                    <div class="actions">
                        <button class="action-btn view-btn" type="button" onclick="alert('Booking ID: #<?= (int) $booking['id'] ?>\nShow: <?= e($booking['show_name']) ?>\nSeats: <?= e($booking['seats']) ?>\nVenue: <?= e($booking['venue']) ?>');">View Ticket</button>
                        <button class="action-btn download-btn" type="button" onclick="window.print();">Download</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div id="no-results" class="no-results"></div>
</section>
<footer class="site-footer"><div class="footer-grid"><div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div><div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div><div class="footer-col"><h4>Support</h4><a href="profile.php">Profile</a><a href="My_Bookings.php">My Bookings</a><a href="sign_up.php">Sign Up</a></div><div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div></div><div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div></footer>
<script src="search.js"></script>
</body>
</html>
