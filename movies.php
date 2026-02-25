<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Now Showing | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .movies-shell {
            max-width: 1140px;
            margin: 0 auto;
            padding: 36px 20px 60px;
        }

        .hero {
            text-align: left;
            padding: 30px;
            border-radius: 14px;
            color: #ffffff;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
        }

        .filter-bar {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter {
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(14, 165, 233, 0.16);
            border: 1px solid rgba(14, 165, 233, 0.28);
            font-size: 13px;
        }

        .movies-grid {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.16);
        }

        .poster img {
            width: 100%;
            height: 320px;
            object-fit: cover;
        }

        .info {
            padding: 14px;
        }

        .info h3 {
            margin-bottom: 6px;
        }

        .book {
            margin-top: 10px;
            width: 100%;
            border: none;
            border-radius: 8px;
            padding: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            cursor: pointer;
        }

        .book:hover {
            filter: brightness(0.95);
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
        </nav>
</header>

<div class="movies-shell">
    <section class="hero">
        <h1>Now Showing</h1>
        <p>Handpicked movies, updated regularly.</p>
        <div class="filter-bar">
            <div class="filter">Hindi</div>
            <div class="filter">Gujarati</div>
            <div class="filter">UA</div>
            <div class="filter">Coming Soon</div>
        </div>
    </section>

    <section class="movies-grid">
        <div class="card searchable-card" data-search="kung fu panda movie hindi ua16 family animation">
            <div class="poster">
                <img src="m74S9tsrUQUYB8Raou21B6zjbcr.jpg" alt="Kung Fu Panda">
            </div>
            <div class="info">
                <h3>Kung Fu Panda</h3>
                <span>8.9 | UA16+ | Hindi</span>
                <button class="book">Book Tickets</button>
            </div>
        </div>

        <div class="card searchable-card" data-search="lagan laagii re gujarati movie drama">
            <div class="poster">
                <img src="lagan-laagii-re.jpg" alt="Lagan Laagii Re">
            </div>
            <div class="info">
                <h3>Lagan Laagii Re</h3>
                <span>9.1 | UA13+ | Gujarati</span>
                <button class="book">Book Tickets</button>
            </div>
        </div>

        <div class="card searchable-card" data-search="bhabiji ghar par hain hindi comedy movie">
            <div class="poster">
                <img src="bhabiji-ghar-par-hain.jpg" alt="Bhabiji Ghar Par Hain">
            </div>
            <div class="info">
                <h3>Bhabiji Ghar Par Hain!</h3>
                <span>9.0 | UA16+ | Hindi</span>
                <button class="book">Book Tickets</button>
            </div>
        </div>

        <div class="card searchable-card" data-search="pass na pass gujarati movie">
            <div class="poster">
                <img src="pass na pass.jpg" alt="Pass Na Pass">
            </div>
            <div class="info">
                <h3>Pass Na Pass</h3>
                <span>7.1 | UA | Gujarati</span>
                <button class="book">Book Tickets</button>
            </div>
        </div>
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

