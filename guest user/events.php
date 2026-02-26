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
    <p>Discover concerts, comedy shows, workshops, and festivals happening near you.</p>

    <div class="events-grid">
        <div class="event-card searchable-card" data-search="arijit singh live concert mumbai dy patil music">
            <h3>Arijit Singh Live</h3>
            <div class="event-meta">16 Mar 2026<br>DY Patil Stadium, Mumbai<br>From INR 1999</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
        </div>

        <div class="event-card searchable-card" data-search="zakir khan stand-up comedy pune bal gandharva">
            <h3>Zakir Khan Stand-up</h3>
            <div class="event-meta">22 Mar 2026<br>Bal Gandharva, Pune<br>From INR 899</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
        </div>

        <div class="event-card searchable-card" data-search="sunburn arena delhi jln stadium dj">
            <h3>Sunburn Arena</h3>
            <div class="event-meta">29 Mar 2026<br>JLN Stadium, Delhi<br>From INR 1499</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
        </div>

        <div class="event-card searchable-card" data-search="food music fest ahmedabad festival">
            <h3>Food &amp; Music Fest</h3>
            <div class="event-meta">5 Apr 2026<br>Riverfront Ground, Ahmedabad<br>From INR 499</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
        </div>

        <div class="event-card searchable-card" data-search="startup networking night gandhinagar gift city">
            <h3>Startup Networking Night</h3>
            <div class="event-meta">11 Apr 2026<br>GIFT City Club, Gandhinagar<br>From INR 699</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
        </div>

        <div class="event-card searchable-card" data-search="classical evening ncpa mumbai music">
            <h3>Classical Evening</h3>
            <div class="event-meta">18 Apr 2026<br>NCPA, Mumbai<br>From INR 799</div>
            <button class="book-btn" onclick="window.location.href='sign_in.php'">Book Tickets</button>
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

