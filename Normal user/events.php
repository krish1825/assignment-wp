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

$events = fetch_events();
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="events.css">
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
<section class="events-page">
    <h1>Upcoming Events</h1>
    <p>Discover <?= count($events) ?> active concerts, comedy shows, festivals, and experiences happening near you.</p>
    <div class="events-grid">
        <?php foreach ($events as $event): ?>
            <?php
            $eventCity = trim((string) (strrchr((string) $event['location'], ',') ?: 'Ahmedabad'), ', ');
            $bookingDate = ((string) $event['event_date'] >= $today) ? (string) $event['event_date'] : $today;
            ?>
            <div class="event-card searchable-card" data-search="<?= e(strtolower($event['name'] . ' ' . $event['category'] . ' ' . $event['location'])) ?>">
                <h3><?= e($event['name']) ?></h3>
                <div class="event-meta">
                    <?= e(date('d M Y', strtotime((string) $event['event_date']))) ?><br>
                    <?= e(date('h:i A', strtotime((string) $event['event_time']))) ?><br>
                    <?= e($event['location']) ?><br>
                    From INR <?= number_format((float) $event['ticket_price'], 0) ?>
                </div>
                <button class="book-btn" onclick="window.location.href='time-slot-venue.php?show=<?= rawurlencode((string) $event['name']) ?>&date=<?= e($bookingDate) ?>&city=<?= rawurlencode($eventCity) ?>'">Book Tickets</button>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="no-results" class="no-results"></div>
</section>
<footer class="site-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <h4>Ticketvarse</h4>
            <p>Book movie and event tickets with easy checkout and best prices.</p>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <a href="home.php">Home</a>
            <a href="movies.php">Movies</a>
            <a href="events.php">Events</a>
            <a href="Offers.php">Offers</a>
        </div>
        <div class="footer-col">
            <h4>Support</h4>
            <a href="profile.php">Profile</a>
            <a href="My_Bookings.php">My Bookings</a>
            <a href="sign_up.php">Sign Up</a>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <p>Email: support@ticketvarse.com</p>
            <p>Phone: +91 90000 00000</p>
        </div>
    </div>
    <div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div>
</footer>
<script src="search.js"></script>
</body>
</html>
