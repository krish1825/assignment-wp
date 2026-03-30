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
$languages = [];
$genres = [];
$today = date('Y-m-d');
foreach ($movies as $movie) {
    $languages[] = trim((string) $movie['language']);
    $genres[] = trim((string) $movie['genre']);
}
$languages = array_values(array_unique(array_filter($languages)));
$genres = array_values(array_unique(array_filter($genres)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Now Showing | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="movies.css">
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
<div class="movies-shell">
    <section class="hero">
        <h1>Now Showing</h1>
        <p>Browse <?= count($movies) ?> active movies from the Ticketvarse database.</p>
        <div class="filter-bar">
            <?php foreach ($languages as $language): ?>
                <div class="filter"><?= e($language) ?></div>
            <?php endforeach; ?>
            <?php foreach ($genres as $genre): ?>
                <div class="filter"><?= e(ucfirst($genre)) ?></div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="movies-grid">
        <?php foreach ($movies as $movie): ?>
            <?php $bookingDate = ((string) $movie['release_date'] >= $today) ? (string) $movie['release_date'] : $today; ?>
            <div class="card searchable-card" data-search="<?= e(strtolower($movie['title'] . ' ' . $movie['genre'] . ' ' . $movie['language'])) ?>">
                <div class="poster">
                    <img src="<?= e(guest_media_path($movie['image_path'], default_movie_image())) ?>" alt="<?= e($movie['title']) ?>">
                </div>
                <div class="info">
                    <h3><?= e($movie['title']) ?></h3>
                    <span><?= e(ucfirst((string) $movie['genre'])) ?> | <?= e($movie['language']) ?> | INR <?= number_format((float) $movie['ticket_price'], 0) ?></span>
                    <button class="book" onclick="window.location.href='time-slot-venue.php?show=<?= rawurlencode((string) $movie['title']) ?>&date=<?= e($bookingDate) ?>&city=Ahmedabad'">Book Tickets</button>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <div id="no-results" class="no-results"></div>
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
