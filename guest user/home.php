<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

$movies = fetch_movies();
$events = fetch_events();
$trendingItems = fetch_home_trending();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketvarse | Book Tickets | Guest User</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="home-search.css">
</head>

<body>

<<<<<<< Updated upstream
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="sign_in.php">My Bookings</a>
        <button class="btn" onclick="window.location.href='Sign_in.php'">Sign In</button>
    </nav>
</header>

<div class="home-shell">
    <section class="hero">
        <h1>Book Movie and Live Event Tickets</h1>
        <p>Explore <?= count($movies) ?> movies and <?= count($events) ?> live events now available on Ticketvarse.</p>

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
            <p>See <?= count($movies) ?> active movie listings and reserve your preferred seats.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="events concerts comedy shows" href="events.php">
            <h3>Live Events</h3>
            <p>Browse <?= count($events) ?> upcoming concerts, comedy shows, and experiences.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="offers discount deal promo cashback" href="Offers.php">
            <h3>Offers</h3>
            <p>Apply promo codes and get discounts on your bookings.</p>
        </a>
        <a class="quick-link-card searchable-card" data-search="my bookings tickets confirmed upcoming" href="sign_in.php">
            <h3>My Bookings</h3>
            <p>Sign in to track upcoming tickets and download confirmed passes.</p>
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
=======
    <header class="navbar">
        <div class="logo">Ticketvarse</div>
        <nav>
>>>>>>> Stashed changes
            <a href="home.php">Home</a>
            <a href="movies.php">Movies</a>
            <a href="events.php">Events</a>
            <a href="Offers.php">Offers</a>
<<<<<<< Updated upstream
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
=======
            <a href="sign_in.php">My Bookings</a>
            <button class="btn" onclick="window.location.href='sign_in.php'">Sign In</button>
        </nav>
    </header>

    <div class="home-shell">
        <section class="hero">
            <h1>Book Movie and Live Event Tickets</h1>
            <p>Explore movies, concerts, comedy, and festivals. Choose your show and book in a few clicks.</p>

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
                <p>See now showing films and reserve your preferred seats.</p>
            </a>
            <a class="quick-link-card searchable-card" data-search="events concerts comedy shows" href="events.php">
                <h3>Live Events</h3>
                <p>Find concerts, stand-up shows, and weekend experiences.</p>
            </a>
            <a class="quick-link-card searchable-card" data-search="offers discount deal promo cashback" href="Offers.php">
                <h3>Offers</h3>
                <p>Apply promo codes and get discounts on your bookings.</p>
            </a>
            <a class="quick-link-card searchable-card" data-search="my bookings tickets confirmed upcoming" href="My_Bookings.php">
                <h3>My Bookings</h3>
                <p>Track upcoming tickets and download confirmed passes.</p>
            </a>
        </section>

        <section class="section">
            <h2>Trending Now</h2>
            <div class="cards">
                <div class="event-card searchable-card" data-search="kung fu panda movie hindi">
                    <img class="card-photo" src="m74S9tsrUQUYB8Raou21B6zjbcr.jpg" alt="Kung Fu Panda Poster">
                    <h3>Kung Fu Panda</h3>
                    <p>Movie | From INR 499</p>
                    <a href="movies.php">Book movie</a>
                </div>
                <div class="event-card searchable-card" data-search="arijit singh live concert mumbai event">
                    <img class="card-photo" src="arijit-singh.jpg" alt="Arijit Singh Live Poster">
                    <h3>Arijit Singh Live</h3>
                    <p>Concert | From INR 1999</p>
                    <a href="events.php">Book event</a>
                </div>
                <div class="event-card searchable-card" data-search="zakir khan stand-up comedy event">
                    <img class="card-photo" src="zakhir-khan.jpg" alt="Zakir Khan Stand-up Poster">
                    <h3>Zakir Khan Stand-up</h3>
                    <p>Comedy | From INR 899</p>
                    <a href="events.php">Book event</a>
                </div>
                <div class="event-card searchable-card" data-search="weekend combo offer deals discount">
                    <img class="card-photo" src="weekend-combo-offer.jpg" alt="Weekend Combo Offer Poster">
                    <h3>Weekend Combo Offer</h3>
                    <p>Deals | Save up to 20%</p>
                    <a href="Offers.php">See offer</a>
                </div>
            </div>
            <div id="no-results" class="no-results"></div>
        </section>
>>>>>>> Stashed changes
    </div>

<<<<<<< Updated upstream
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="../assets/js/form-validation.js"></script>
<script src="search.js"></script>
</body>
</html>
=======
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
                <a href="My_Bookings.php">My Bookings</a>
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
>>>>>>> Stashed changes
