<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Booking | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="seat-booking.css">
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

<main class="seat-page">
    <section class="seat-header">
        <div class="seat-header-copy">
            <h1>Select Your Seats</h1>
            <p>Fast checkout, live seat availability, and transparent pricing.</p>
            <span class="trust-pill">Secure booking session with live inventory lock</span>
        </div>
        <div class="show-controls">
            <label>
                Show
                <select id="showSelect">
                    <option value="Kung Fu Panda (Hindi 2D)">Kung Fu Panda (Hindi 2D)</option>
                    <option value="Arijit Singh Live Concert">Arijit Singh Live Concert</option>
                    <option value="Zakir Khan Stand-up Special">Zakir Khan Stand-up Special</option>
                </select>
            </label>
            <label>
                Date
                <input id="showDate" type="date" value="2026-03-16">
            </label>
            <label>
                Time
                <select id="showTime">
                    <option>04:30 PM</option>
                    <option selected>07:30 PM</option>
                    <option>10:15 PM</option>
                </select>
            </label>
        </div>
    </section>

    <section class="seat-layout-shell">
        <div class="seat-map-card">
            <div class="legend">
                <span><i class="seat-swatch available"></i>Available</span>
                <span><i class="seat-swatch selected"></i>Selected</span>
                <span><i class="seat-swatch occupied"></i>Booked</span>
            </div>
            <div class="seat-tools">
                <p id="selectionHint">Pick up to 8 seats.</p>
                <button id="clearSelectionBtn" type="button" class="clear-btn" disabled>Clear Selection</button>
            </div>

            <div class="seat-zones">
                <div class="zone-row"><strong>Premium</strong><small>INR 420</small></div>
                <div class="zone-row"><strong>Classic</strong><small>INR 280</small></div>
                <div class="zone-row"><strong>Budget</strong><small>INR 180</small></div>
            </div>

            <div class="screen-wrap">
                <div class="screen">SCREEN / STAGE</div>
            </div>

            <div class="seats-wrap" id="seatsWrap">
                <div class="seat-row-label">A</div>
                <button class="seat premium occupied" data-seat="A1" data-price="420" disabled>A1</button>
                <button class="seat premium" data-seat="A2" data-price="420">A2</button>
                <button class="seat premium" data-seat="A3" data-price="420">A3</button>
                <button class="seat premium" data-seat="A4" data-price="420">A4</button>
                <button class="seat premium occupied" data-seat="A5" data-price="420" disabled>A5</button>
                <span class="aisle"></span>
                <button class="seat premium" data-seat="A6" data-price="420">A6</button>
                <button class="seat premium" data-seat="A7" data-price="420">A7</button>
                <button class="seat premium occupied" data-seat="A8" data-price="420" disabled>A8</button>
                <button class="seat premium" data-seat="A9" data-price="420">A9</button>
                <button class="seat premium" data-seat="A10" data-price="420">A10</button>

                <div class="seat-row-label">B</div>
                <button class="seat premium" data-seat="B1" data-price="420">B1</button>
                <button class="seat premium" data-seat="B2" data-price="420">B2</button>
                <button class="seat premium occupied" data-seat="B3" data-price="420" disabled>B3</button>
                <button class="seat premium" data-seat="B4" data-price="420">B4</button>
                <button class="seat premium" data-seat="B5" data-price="420">B5</button>
                <span class="aisle"></span>
                <button class="seat premium" data-seat="B6" data-price="420">B6</button>
                <button class="seat premium occupied" data-seat="B7" data-price="420" disabled>B7</button>
                <button class="seat premium" data-seat="B8" data-price="420">B8</button>
                <button class="seat premium" data-seat="B9" data-price="420">B9</button>
                <button class="seat premium" data-seat="B10" data-price="420">B10</button>

                <div class="seat-row-label">C</div>
                <button class="seat classic" data-seat="C1" data-price="280">C1</button>
                <button class="seat classic" data-seat="C2" data-price="280">C2</button>
                <button class="seat classic occupied" data-seat="C3" data-price="280" disabled>C3</button>
                <button class="seat classic" data-seat="C4" data-price="280">C4</button>
                <button class="seat classic" data-seat="C5" data-price="280">C5</button>
                <span class="aisle"></span>
                <button class="seat classic" data-seat="C6" data-price="280">C6</button>
                <button class="seat classic" data-seat="C7" data-price="280">C7</button>
                <button class="seat classic occupied" data-seat="C8" data-price="280" disabled>C8</button>
                <button class="seat classic" data-seat="C9" data-price="280">C9</button>
                <button class="seat classic" data-seat="C10" data-price="280">C10</button>

                <div class="seat-row-label">D</div>
                <button class="seat classic" data-seat="D1" data-price="280">D1</button>
                <button class="seat classic occupied" data-seat="D2" data-price="280" disabled>D2</button>
                <button class="seat classic" data-seat="D3" data-price="280">D3</button>
                <button class="seat classic" data-seat="D4" data-price="280">D4</button>
                <button class="seat classic" data-seat="D5" data-price="280">D5</button>
                <span class="aisle"></span>
                <button class="seat classic" data-seat="D6" data-price="280">D6</button>
                <button class="seat classic occupied" data-seat="D7" data-price="280" disabled>D7</button>
                <button class="seat classic" data-seat="D8" data-price="280">D8</button>
                <button class="seat classic" data-seat="D9" data-price="280">D9</button>
                <button class="seat classic" data-seat="D10" data-price="280">D10</button>

                <div class="seat-row-label">E</div>
                <button class="seat budget" data-seat="E1" data-price="180">E1</button>
                <button class="seat budget" data-seat="E2" data-price="180">E2</button>
                <button class="seat budget occupied" data-seat="E3" data-price="180" disabled>E3</button>
                <button class="seat budget" data-seat="E4" data-price="180">E4</button>
                <button class="seat budget" data-seat="E5" data-price="180">E5</button>
                <span class="aisle"></span>
                <button class="seat budget" data-seat="E6" data-price="180">E6</button>
                <button class="seat budget" data-seat="E7" data-price="180">E7</button>
                <button class="seat budget occupied" data-seat="E8" data-price="180" disabled>E8</button>
                <button class="seat budget" data-seat="E9" data-price="180">E9</button>
                <button class="seat budget" data-seat="E10" data-price="180">E10</button>

                <div class="seat-row-label">F</div>
                <button class="seat budget" data-seat="F1" data-price="180">F1</button>
                <button class="seat budget occupied" data-seat="F2" data-price="180" disabled>F2</button>
                <button class="seat budget" data-seat="F3" data-price="180">F3</button>
                <button class="seat budget" data-seat="F4" data-price="180">F4</button>
                <button class="seat budget" data-seat="F5" data-price="180">F5</button>
                <span class="aisle"></span>
                <button class="seat budget" data-seat="F6" data-price="180">F6</button>
                <button class="seat budget" data-seat="F7" data-price="180">F7</button>
                <button class="seat budget" data-seat="F8" data-price="180">F8</button>
                <button class="seat budget occupied" data-seat="F9" data-price="180" disabled>F9</button>
                <button class="seat budget" data-seat="F10" data-price="180">F10</button>
            </div>
        </div>

        <aside class="summary-card">
            <h2>Booking Summary</h2>
            <div class="summary-item"><span>Show</span><strong id="summaryShow">Kung Fu Panda (Hindi 2D)</strong></div>
            <div class="summary-item"><span>Date</span><strong id="summaryDate">2026-03-16</strong></div>
            <div class="summary-item"><span>Time</span><strong id="summaryTime">07:30 PM</strong></div>
            <div class="summary-item"><span>Session Hold</span><strong id="holdTimer">10:00</strong></div>
            <div class="summary-item"><span>Seats</span><strong id="summarySeats">None selected</strong></div>
            <div class="summary-item"><span>Tickets</span><strong id="summaryCount">0</strong></div>
            <hr>
            <div class="summary-item"><span>Subtotal</span><strong id="summarySubtotal">INR 0</strong></div>
            <div class="summary-item"><span>Convenience Fee</span><strong id="summaryFee">INR 0</strong></div>
            <div class="summary-item total"><span>Total</span><strong id="summaryTotal">INR 0</strong></div>
            <button id="payBtn" class="pay-btn" disabled>Proceed To Pay</button>
            <small class="helper-text">Final price may include applicable taxes.</small>
        </aside>
    </section>
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

<script src="seat-booking.js"></script>
</body>
</html>

