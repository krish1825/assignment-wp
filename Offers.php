<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .offers-page {
            padding: 30px 40px 50px;
        }

        .offers-page h1 {
            margin-bottom: 8px;
            color: var(--text);
        }

        .offers-page p {
            margin-bottom: 24px;
            color: var(--muted);
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }

        .offer-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .offer-type {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-strong);
            background: var(--accent-soft);
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .offer-card h3 {
            margin-bottom: 8px;
            color: #111827;
        }

        .offer-code {
            margin: 10px 0;
            padding: 8px 10px;
            border: 1px dashed #94a3b8;
            border-radius: 6px;
            color: #111827;
            font-weight: 700;
            background: var(--surface-soft);
        }

        .offer-meta {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .claim-btn {
            margin-top: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            padding: 10px;
            background: var(--success);
            color: #fff;
            cursor: pointer;
        }

        .claim-btn:hover {
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

<section class="offers-page">
    <h1>Best Offers For You</h1>
    <p>Apply these promo codes while booking movies and events to save more.</p>

    <div class="offers-grid">
        <div class="offer-card searchable-card" data-search="movie offer flat 20 percent off movie20">
            <span class="offer-type">Movie Offer</span>
            <h3>Flat 20% Off on Movie Tickets</h3>
            <p class="offer-code">Code: MOVIE20</p>
            <p class="offer-meta">Valid till: 31 Mar 2026<br>Min booking: INR 500</p>
            <button class="claim-btn">Claim Offer</button>
        </div>

        <div class="offer-card searchable-card" data-search="event offer save 300 event300 live events">
            <span class="offer-type">Event Offer</span>
            <h3>Save INR 300 on Live Events</h3>
            <p class="offer-code">Code: EVENT300</p>
            <p class="offer-meta">Valid till: 10 Apr 2026<br>Min booking: INR 1500</p>
            <button class="claim-btn">Claim Offer</button>
        </div>

        <div class="offer-card searchable-card" data-search="wallet cashback upi upi10 10 percent">
            <span class="offer-type">Wallet Cashback</span>
            <h3>10% Cashback via UPI</h3>
            <p class="offer-code">Code: UPI10</p>
            <p class="offer-meta">Valid till: 25 Mar 2026<br>Max cashback: INR 150</p>
            <button class="claim-btn">Claim Offer</button>
        </div>

        <div class="offer-card searchable-card" data-search="weekend deal bogo buy 1 get 1 weekendbogo">
            <span class="offer-type">Weekend Deal</span>
            <h3>Buy 1 Get 1 on Saturday Shows</h3>
            <p class="offer-code">Code: WEEKENDBOGO</p>
            <p class="offer-meta">Valid on Saturdays only<br>Selected cinemas only</p>
            <button class="claim-btn">Claim Offer</button>
        </div>

        <div class="offer-card searchable-card" data-search="new user first booking first200 200 off">
            <span class="offer-type">New User</span>
            <h3>Flat INR 200 Off on First Booking</h3>
            <p class="offer-code">Code: FIRST200</p>
            <p class="offer-meta">Valid till: 30 Apr 2026<br>For new users only</p>
            <button class="claim-btn">Claim Offer</button>
        </div>

        <div class="offer-card searchable-card" data-search="premium vip passes vip15 15 percent off">
            <span class="offer-type">Premium</span>
            <h3>15% Off on VIP Event Passes</h3>
            <p class="offer-code">Code: VIP15</p>
            <p class="offer-meta">Valid till: 20 Apr 2026<br>Max discount: INR 1000</p>
            <button class="claim-btn">Claim Offer</button>
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

