<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

$events = fetch_events();
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
        <a href="sign_in.php">My Bookings</a>
    </nav>
</header>

<section class="events-page">
    <h1>Upcoming Events</h1>
    <p>Discover <?= count($events) ?> concerts, comedy shows, festivals, and experiences happening near you.</p>

    <div class="events-grid">
        <?php foreach ($events as $event): ?>
            <div class="event-card searchable-card" data-search="<?= e(strtolower($event['name'] . ' ' . $event['category'] . ' ' . $event['location'])) ?>">
                <h3><?= e($event['name']) ?></h3>
                <div class="event-meta">
                    <?= e(date('d M Y', strtotime((string) $event['event_date']))) ?><br>
                    <?= e(date('h:i A', strtotime((string) $event['event_time']))) ?><br>
                    <?= e($event['location']) ?><br>
                    From INR <?= number_format((float) $event['ticket_price'], 0) ?>
                </div>
                <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
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
            <a href="sign_in.php">My Bookings</a>
            <a href="Sign_in.php">Sign In</a>
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
