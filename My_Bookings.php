<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .bookings-page {
            padding: 30px 40px 50px;
        }

        .bookings-page h1 {
            margin-bottom: 8px;
            color: var(--text);
        }

        .bookings-page p {
            margin-bottom: 24px;
            color: var(--muted);
        }

        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
        }

        .booking-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .booking-type {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-strong);
            background: var(--accent-soft);
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .booking-card h3 {
            color: #111827;
            margin-bottom: 10px;
        }

        .booking-meta {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .status {
            display: inline-block;
            margin-top: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status.confirmed {
            color: #065f46;
            background: #d1fae5;
        }

        .status.upcoming {
            color: var(--accent-strong);
            background: var(--accent-soft);
        }

        .actions {
            margin-top: 14px;
            display: flex;
            gap: 8px;
        }

        .action-btn {
            flex: 1;
            border: none;
            border-radius: 6px;
            padding: 9px;
            cursor: pointer;
            color: #fff;
        }

        .view-btn {
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
        }

        .download-btn {
            background: var(--success);
        }

        .view-btn:hover {
            filter: brightness(0.95);
        }

        .download-btn:hover {
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

<section class="bookings-page">
    <h1>My Bookings</h1>
    <p>Track all your movie and event bookings in one place.</p>

    <div class="bookings-grid">
        <div class="booking-card searchable-card" data-search="kung fu panda movie booking confirmed g5 g6">
            <span class="booking-type">Movie</span>
            <h3>Kung Fu Panda</h3>
            <p class="booking-meta">Date: 21 Feb 2026<br>Time: 7:30 PM<br>Seats: G5, G6<br>Amount: INR 998</p>
            <span class="status confirmed">Confirmed</span>
            <div class="actions">
                <button class="action-btn view-btn">View Ticket</button>
                <button class="action-btn download-btn">Download</button>
            </div>
        </div>

        <div class="booking-card searchable-card" data-search="arijit singh live event booking upcoming silver">
            <span class="booking-type">Event</span>
            <h3>Arijit Singh Live</h3>
            <p class="booking-meta">Date: 16 Mar 2026<br>Time: 8:00 PM<br>Passes: 2 Silver<br>Amount: INR 3998</p>
            <span class="status upcoming">Upcoming</span>
            <div class="actions">
                <button class="action-btn view-btn">View Ticket</button>
                <button class="action-btn download-btn">Download</button>
            </div>
        </div>

        <div class="booking-card searchable-card" data-search="lagan laagii re movie booking confirmed c2 c3">
            <span class="booking-type">Movie</span>
            <h3>Lagan Laagii Re</h3>
            <p class="booking-meta">Date: 25 Feb 2026<br>Time: 5:15 PM<br>Seats: C2, C3<br>Amount: INR 780</p>
            <span class="status confirmed">Confirmed</span>
            <div class="actions">
                <button class="action-btn view-btn">View Ticket</button>
                <button class="action-btn download-btn">Download</button>
            </div>
        </div>

        <div class="booking-card searchable-card" data-search="zakir khan stand-up event booking upcoming gold">
            <span class="booking-type">Event</span>
            <h3>Zakir Khan Stand-up</h3>
            <p class="booking-meta">Date: 22 Mar 2026<br>Time: 9:00 PM<br>Passes: 1 Gold<br>Amount: INR 1299</p>
            <span class="status upcoming">Upcoming</span>
            <div class="actions">
                <button class="action-btn view-btn">View Ticket</button>
                <button class="action-btn download-btn">Download</button>
            </div>
        </div>
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

