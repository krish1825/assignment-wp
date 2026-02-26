<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Venue & Time | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="time-slot-venue.css">
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

    <main class="slot-page">
        <section class="slot-hero">
            <div>
                <h1>Choose Venue and Time</h1>
                <p>Find the most convenient location and preferred show timing in one step.</p>
                <span class="show-chip" id="selectedShowLabel">Now booking: Kung Fu Panda (Hindi 2D)</span>
            </div>
            <div class="date-picker">
                <label for="showDate">Date</label>
                <input type="date" id="showDate">
            </div>
        </section>

        <section class="city-switch" id="citySwitch">
            <button class="city-pill active" data-city="Ahmedabad">Ahmedabad</button>
            <button class="city-pill" data-city="Mumbai">Mumbai</button>
            <button class="city-pill" data-city="Pune">Pune</button>
            <button class="city-pill" data-city="Delhi">Delhi</button>
        </section>

        <section class="venues-grid" id="venueGrid">
            <article class="venue-card" data-city="Ahmedabad">
                <div class="venue-head">
                    <h3>Cinepolis: Alpha One</h3>
                    <p>Vastrapur, Ahmedabad</p>
                </div>
                <div class="venue-meta">
                    <span>4K + Dolby</span>
                    <span>Food Court</span>
                    <span>Parking</span>
                </div>
                <div class="times">
                    <button class="time-btn" data-time="10:15 AM">10:15 AM</button>
                    <button class="time-btn" data-time="01:35 PM">01:35 PM</button>
                    <button class="time-btn" data-time="04:45 PM">04:45 PM</button>
                    <button class="time-btn" data-time="07:30 PM">07:30 PM</button>
                </div>
            </article>

            <article class="venue-card" data-city="Ahmedabad">
                <div class="venue-head">
                    <h3>PVR: Acropolis Mall</h3>
                    <p>Thaltej, Ahmedabad</p>
                </div>
                <div class="venue-meta">
                    <span>Laser</span>
                    <span>Recliner</span>
                    <span>Parking</span>
                </div>
                <div class="times">
                    <button class="time-btn" data-time="11:00 AM">11:00 AM</button>
                    <button class="time-btn" data-time="02:20 PM">02:20 PM</button>
                    <button class="time-btn" data-time="06:00 PM">06:00 PM</button>
                    <button class="time-btn" data-time="09:40 PM">09:40 PM</button>
                </div>
            </article>

            <article class="venue-card" data-city="Mumbai">
                <div class="venue-head">
                    <h3>INOX: R-City</h3>
                    <p>Ghatkopar, Mumbai</p>
                </div>
                <div class="venue-meta">
                    <span>Dolby Atmos</span>
                    <span>Premium Seats</span>
                    <span>Parking</span>
                </div>
                <div class="times">
                    <button class="time-btn" data-time="10:30 AM">10:30 AM</button>
                    <button class="time-btn" data-time="01:50 PM">01:50 PM</button>
                    <button class="time-btn" data-time="05:20 PM">05:20 PM</button>
                    <button class="time-btn" data-time="08:45 PM">08:45 PM</button>
                </div>
            </article>

            <article class="venue-card" data-city="Pune">
                <div class="venue-head">
                    <h3>PVR: Phoenix Marketcity</h3>
                    <p>Viman Nagar, Pune</p>
                </div>
                <div class="venue-meta">
                    <span>IMAX</span>
                    <span>Food Court</span>
                    <span>Valet</span>
                </div>
                <div class="times">
                    <button class="time-btn" data-time="09:50 AM">09:50 AM</button>
                    <button class="time-btn" data-time="01:10 PM">01:10 PM</button>
                    <button class="time-btn" data-time="04:20 PM">04:20 PM</button>
                    <button class="time-btn" data-time="07:55 PM">07:55 PM</button>
                </div>
            </article>

            <article class="venue-card" data-city="Delhi">
                <div class="venue-head">
                    <h3>Cinepolis: DLF Avenue</h3>
                    <p>Saket, Delhi</p>
                </div>
                <div class="venue-meta">
                    <span>4K Laser</span>
                    <span>Lounge</span>
                    <span>Parking</span>
                </div>
                <div class="times">
                    <button class="time-btn" data-time="10:40 AM">10:40 AM</button>
                    <button class="time-btn" data-time="02:00 PM">02:00 PM</button>
                    <button class="time-btn" data-time="05:30 PM">05:30 PM</button>
                    <button class="time-btn" data-time="09:10 PM">09:10 PM</button>
                </div>
            </article>
        </section>

        <aside class="selection-bar">
            <div class="selection-meta">
                <strong id="summaryShow">Kung Fu Panda (Hindi 2D)</strong>
                <span id="summaryVenue">Venue: Not selected</span>
                <span id="summaryTime">Time: Not selected</span>
                <span id="summaryDate">Date: Not selected</span>
            </div>
            <button id="continueBtn" class="continue-btn" >Continue To Seat Selection</button>
        </aside>
    </main>

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

    <script src="time-slot-venue.js"></script>
</body>

</html>