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

$movies = fetch_movies();
$events = fetch_events();
$trendingItems = fetch_home_trending();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketvarse | Book Tickets | Normal User</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="home-search.css">
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
        <button class="btn" onclick="window.location.href='../logout.php'">Logout</button>
    </nav>
</header>
<div class="home-shell">
    <section class="hero">
        <h1>Book Movie and Live Event Tickets</h1>
        <p>Explore <?= count($movies) ?> active movies and <?= count($events) ?> active live events available for booking.</p>
        <div class="hero-actions">
            <a class="hero-link primary" href="movies.php">Browse Movies</a>
            <a class="hero-link secondary" href="events.php">Explore Events</a>
            <a class="hero-link secondary" href="Offers.php">View Offers</a>
        </div>
    </section>
    <section class="home-search-wrap">
        <h2>Search Ticketvarse</h2>
        <form class="search-form" onsubmit="return handleSiteSearch(event)">
            <input type="text" name="search" placeholder="Search movies, events, offers, bookings">
            <button type="submit">Search</button>
        </form>
    </section>
    <section class="quick-links">
        <a class="quick-link-card searchable-card" data-search="movies film now showing ticket" href="movies.php">
            <h3>Movies</h3>
            <p>See <?= count($movies) ?> live movie listings and reserve your preferred seats.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="events concerts comedy shows" href="events.php">
            <h3>Live Events</h3>
            <p>Browse <?= count($events) ?> upcoming concerts, comedy shows, and experiences.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="offers discount deal promo cashback" href="Offers.php">
            <h3>Offers</h3>
            <p>Apply promo codes and get discounts on your bookings.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="my bookings tickets confirmed upcoming" href="My_Bookings.php">
            <h3>My Bookings</h3>
            <p>Track your upcoming tickets and download confirmed passes.</p>
        </a>
    </section>
    <section class="section">
        <h2>Trending Now</h2>
        <div class="cards">
            <?php foreach ($trendingItems as $item): ?>
                <?php if ($item['item_type'] === 'movie'): ?>
                    <div class="event-card searchable-card" data-search="<?= e(strtolower($item['title'] . ' ' . $item['genre'] . ' ' . $item['language'])) ?>">
                        <img class="card-photo" src="<?= e(guest_media_path($item['image_path'], default_movie_image())) ?>" alt="<?= e($item['title']) ?>">
                        <h3><?= e($item['title']) ?></h3>
                        <p>Movie | From INR <?= number_format((float) $item['ticket_price'], 0) ?></p>
                        <a href="movies.php">Book movie</a>
                    </div>
                <?php else: ?>
                    <div class="event-card searchable-card" data-search="<?= e(strtolower($item['name'] . ' ' . $item['category'] . ' ' . $item['location'])) ?>">
                        <img class="card-photo" src="<?= e(guest_media_path($item['image_path'], default_event_image())) ?>" alt="<?= e($item['name']) ?>">
                        <h3><?= e($item['name']) ?></h3>
                        <p><?= e(ucfirst((string) $item['category'])) ?> | From INR <?= number_format((float) $item['ticket_price'], 0) ?></p>
                        <a href="events.php">Book event</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div id="no-results" class="no-results"></div>
    </section>
</div>
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
