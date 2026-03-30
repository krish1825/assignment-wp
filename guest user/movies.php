<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

$movies = fetch_movies();
$languages = [];
$genres = [];

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
        <a href="sign_in.php">My Bookings</a>
    </nav>
</header>

<div class="movies-shell">
    <section class="hero">
        <h1>Now Showing</h1>
        <p>Browse <?= count($movies) ?> movies pulled directly from the Ticketvarse database.</p>
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
            <div class="card searchable-card" data-search="<?= e(strtolower($movie['title'] . ' ' . $movie['genre'] . ' ' . $movie['language'])) ?>">
                <div class="poster">
                    <img src="<?= e(guest_media_path($movie['image_path'], default_movie_image())) ?>" alt="<?= e($movie['title']) ?>">
                </div>
                <div class="info">
                    <h3><?= e($movie['title']) ?></h3>
                    <span><?= e(ucfirst((string) $movie['genre'])) ?> | <?= e($movie['language']) ?> | INR <?= number_format((float) $movie['ticket_price'], 0) ?></span>
                    <button class="book" onclick="window.location.href='sign_in.php'">Book Tickets</button>
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
