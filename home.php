<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketvarse | Book Tickets</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home-search.css">
    <style>
        .home-shell {
            max-width: 1120px;
            margin: 0 auto;
            padding: 28px 20px 56px;
        }

        .hero {
            border-radius: 16px;
            text-align: left;
            padding: 46px 34px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #ffffff;
        }

        .hero p {
            max-width: 680px;
        }

        .hero-actions {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .hero-link {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
        }

        .hero-link.primary {
            background: var(--accent);
            color: #ffffff;
        }

        .hero-link.secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        .quick-links {
            margin-top: 26px;
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .quick-link-card {
            text-decoration: none;
            color: inherit;
            background: var(--surface);
            border-radius: 12px;
            padding: 18px;
            border: 1px solid var(--line);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .quick-link-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.14);
        }

        .quick-link-card h3 {
            margin-bottom: 8px;
            color: #111827;
        }

        .quick-link-card p {
            color: var(--muted);
            line-height: 1.5;
        }

        .section {
            margin-top: 28px;
            background: var(--surface);
            border-radius: 12px;
            border: 1px solid var(--line);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        }

        .section h2 {
            color: #111827;
        }

        .cards {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        }

        .event-card {
            width: 100%;
            border: 1px solid var(--line);
        }

        .event-card h3 {
            margin-bottom: 6px;
            color: #111827;
        }

        .event-card .card-photo {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            border: 1px solid var(--line);
        }

        .event-card p {
            margin-bottom: 10px;
            color: var(--muted);
        }

        .event-card a {
            display: inline-block;
            text-decoration: none;
            font-weight: 700;
            color: var(--accent-strong);
        }

        .no-results {
            margin-top: 16px;
            background: var(--warning-bg);
            border: 1px solid var(--warning-line);
            color: var(--warning-text);
            border-radius: 8px;
            padding: 12px;
            display: none;
        }

        .site-footer {
            background: rgba(15, 23, 42, 0.95);
            color: #e2e8f0;
            margin-top: 30px;
        }

        .footer-grid {
            max-width: 1120px;
            margin: 0 auto;
            padding: 26px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .footer-col h4 {
            margin-bottom: 10px;
            color: #ffffff;
            font-size: 16px;
        }

        .footer-col a {
            display: block;
            text-decoration: none;
            color: #d1d5db;
            margin-bottom: 8px;
        }

        .footer-col a:hover {
            color: #ffffff;
        }

        .footer-note {
            border-top: 1px solid #374151;
            text-align: center;
            padding: 12px 20px;
            color: #9ca3af;
            font-size: 14px;
        }

        @media (max-width: 700px) {
            .hero {
                padding: 34px 24px;
            }

            .navbar {
                gap: 12px;
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar nav {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="My_Bookings.php">My Bookings</a>
        <button class="btn" onclick="window.location.href='Sign_in.php'">Sign In</button>
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
                <h3>Arijit Singh Live</h3>
                <p>Concert | From INR 1999</p>
                <a href="events.php">Book event</a>
            </div>
            <div class="event-card searchable-card" data-search="zakir khan stand-up comedy event">
                <h3>Zakir Khan Stand-up</h3>
                <p>Comedy | From INR 899</p>
                <a href="events.php">Book event</a>
            </div>
            <div class="event-card searchable-card" data-search="weekend combo offer deals discount">
                <h3>Weekend Combo Offer</h3>
                <p>Deals | Save up to 20%</p>
                <a href="Offers.php">See offer</a>
            </div>
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



