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

$show = trim((string) ($_GET['show'] ?? 'Kung Fu Panda'));
$date = trim((string) ($_GET['date'] ?? date('Y-m-d')));
$time = trim((string) ($_GET['time'] ?? '07:30 PM'));
$venue = trim((string) ($_GET['venue'] ?? 'Cinepolis: Alpha One'));
$city = trim((string) ($_GET['city'] ?? 'Ahmedabad'));
$today = date('Y-m-d');
if ($date === '' || $date < $today) {
    $date = $today;
}

$bookedSeats = fetch_booked_seats($show, $date, $time, $venue);
$bookedLookup = array_fill_keys($bookedSeats, true);
$seatRows = [
    'A' => ['price' => 520, 'class' => 'luxe', 'label' => 'Luxe'],
    'B' => ['price' => 520, 'class' => 'luxe', 'label' => 'Luxe'],
    'C' => ['price' => 380, 'class' => 'prime', 'label' => 'Prime'],
    'D' => ['price' => 380, 'class' => 'prime', 'label' => 'Prime'],
    'E' => ['price' => 280, 'class' => 'classic', 'label' => 'Classic'],
    'F' => ['price' => 280, 'class' => 'classic', 'label' => 'Classic'],
    'G' => ['price' => 220, 'class' => 'classic', 'label' => 'Classic'],
    'H' => ['price' => 320, 'class' => 'couple', 'label' => 'Couple'],
    'I' => ['price' => 320, 'class' => 'couple', 'label' => 'Couple'],
];
$seatColumns = range(1, 16);
$seatStats = [];
foreach ($seatRows as $rowLabel => $meta) {
    $available = 0;
    foreach ($seatColumns as $number) {
        if (!isset($bookedLookup[$rowLabel . $number])) {
            $available++;
        }
    }
    $seatStats[$rowLabel] = $available;
}
$displayDate = date('D, d M', strtotime($date));
?>
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

<div class="seat-count-modal active" id="seatCountModal">
    <div class="seat-count-card">
        <p class="eyebrow">How Many Seats?</p>
        <h2>Select ticket count</h2>
        <p>Choose how many seats you want first, then we will help you pick them together.</p>
        <div class="count-grid" id="countGrid">
            <?php for ($count = 1; $count <= 8; $count++): ?>
                <button type="button" class="count-btn<?= $count === 2 ? ' active' : '' ?>" data-count="<?= $count ?>"><?= $count ?></button>
            <?php endfor; ?>
        </div>
        <button type="button" class="submit-btn modal-continue-btn" id="startSelectionBtn">Start Selecting Seats</button>
    </div>
</div>

<main class="seat-page">
    <section class="compact-booking-bar">
        <div class="compact-title-block">
            <p class="eyebrow">Seat Selection</p>
            <h1><?= e($show) ?></h1>
            <span><?= e($venue) ?>, <?= e($city) ?></span>
        </div>
        <div class="compact-meta-group">
            <div class="compact-pill"><strong><?= e($displayDate) ?></strong><span>Date</span></div>
            <div class="compact-pill"><strong><?= e($time) ?></strong><span>Show Time</span></div>
            <div class="compact-pill"><strong><?= count($bookedSeats) ?></strong><span>Booked</span></div>
            <div class="compact-pill selection-pill"><strong id="targetSeatCount">2</strong><span>Tickets</span></div>
        </div>
    </section>

    <section class="seat-layout-shell">
        <div class="seat-map-card">
            <div class="top-strip">
                <div class="mini-legend">
                    <span><i class="seat-swatch available"></i>Available</span>
                    <span><i class="seat-swatch selected"></i>Selected</span>
                    <span><i class="seat-swatch occupied"></i>Booked</span>
                    <span><i class="seat-swatch couple"></i>Couple</span>
                </div>
                <button id="clearSelectionBtn" type="button" class="clear-btn" disabled>Clear</button>
            </div>

            <div class="layout-body">
                <aside class="row-pricing-panel">
                    <h3>Price Bands</h3>
                    <div class="band-card luxe">
                        <strong>Luxe</strong>
                        <span>Rows A - B</span>
                        <small>INR 520</small>
                    </div>
                    <div class="band-card prime">
                        <strong>Prime</strong>
                        <span>Rows C - D</span>
                        <small>INR 380</small>
                    </div>
                    <div class="band-card classic">
                        <strong>Classic</strong>
                        <span>Rows E - G</span>
                        <small>INR 220 - 280</small>
                    </div>
                    <div class="band-card couple">
                        <strong>Couple</strong>
                        <span>Rows H - I</span>
                        <small>INR 320 per seat</small>
                    </div>
                </aside>

                <div class="auditorium-card">
                    <div class="seat-tools">
                        <p id="selectionHint">Select your preferred ticket count to begin.</p>
                        <span class="selection-badge" id="selectionBadge">0 of 2 selected</span>
                    </div>

                    <div class="screen-zone">
                        <div class="screen-glow"></div>
                        <div class="screen">All eyes this way</div>
                    </div>

                    <div class="rows-wrap" id="seatsWrap">
                        <?php foreach ($seatRows as $rowLabel => $meta): ?>
                            <div class="seat-row-block <?= e($meta['class']) ?>">
                                <div class="row-meta">
                                    <strong><?= e($rowLabel) ?></strong>
                                    <span><?= e($meta['label']) ?></span>
                                    <small><?= (int) $seatStats[$rowLabel] ?> left</small>
                                </div>
                                <div class="seat-grid-row<?= $meta['class'] === 'couple' ? ' couple-row' : '' ?>">
                                    <?php foreach ($seatColumns as $number): ?>
                                        <?php if ($number === 5 || $number === 13): ?><span class="aisle-gap"></span><?php endif; ?>
                                        <?php $seatName = $rowLabel . $number; $isBooked = isset($bookedLookup[$seatName]); ?>
                                        <button
                                            type="button"
                                            class="seat <?= e($meta['class']) ?><?= $isBooked ? ' occupied' : '' ?>"
                                            data-seat="<?= e($seatName) ?>"
                                            data-price="<?= e((string) $meta['price']) ?>"
                                            data-row="<?= e($rowLabel) ?>"
                                            data-band="<?= e($meta['label']) ?>"
                                            data-couple="<?= $meta['class'] === 'couple' ? 'true' : 'false' ?>"
                                            <?= $isBooked ? 'disabled' : '' ?>
                                        >
                                            <span class="seat-arm-left" aria-hidden="true"></span>
                                            <?= e((string) $number) ?>
                                            <span class="seat-arm-right" aria-hidden="true"></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <aside class="summary-card">
            <form id="seatBookingForm" action="payment.php" method="get">
                <input type="hidden" name="show" id="paymentShowInput" value="<?= e($show) ?>">
                <input type="hidden" name="date" id="paymentDateInput" value="<?= e($date) ?>">
                <input type="hidden" name="time" id="paymentTimeInput" value="<?= e($time) ?>">
                <input type="hidden" name="venue" id="paymentVenueInput" value="<?= e($venue) ?>">
                <input type="hidden" name="city" id="paymentCityInput" value="<?= e($city) ?>">
                <input type="hidden" name="seats" id="paymentSeatsInput" value="">
                <input type="hidden" name="subtotal" id="paymentSubtotalInput" value="0">
                <input type="hidden" name="fee" id="paymentFeeInput" value="0">
                <input type="hidden" name="total" id="paymentTotalInput" value="0">

                <div class="summary-top">
                    <p class="eyebrow">Booking Summary</p>
                    <h2><?= e($show) ?></h2>
                    <span class="hold-chip">Session hold: <strong id="holdTimer">10:00</strong></span>
                </div>

                <div class="summary-block">
                    <div class="summary-item"><span>Venue</span><strong><?= e($venue) ?></strong></div>
                    <div class="summary-item"><span>Date</span><strong id="summaryDate"><?= e($displayDate) ?></strong></div>
                    <div class="summary-item"><span>Time</span><strong id="summaryTime"><?= e($time) ?></strong></div>
                    <div class="summary-item"><span>Selected Seats</span><strong id="summarySeats">None selected</strong></div>
                    <div class="summary-item"><span>Ticket Count</span><strong id="summaryCount">0</strong></div>
                </div>

                <div class="summary-selection" id="selectedSeatChips"></div>

                <div class="summary-pricing">
                    <div class="summary-item"><span>Subtotal</span><strong id="summarySubtotal">INR 0</strong></div>
                    <div class="summary-item"><span>Convenience Fee</span><strong id="summaryFee">INR 0</strong></div>
                    <div class="summary-item total"><span>Amount Payable</span><strong id="summaryTotal">INR 0</strong></div>
                </div>

                <button id="payBtn" type="submit" class="pay-btn" disabled>Proceed To Payment</button>
                <small class="helper-text">Tickets once booked cannot be cancelled or exchanged.</small>
            </form>
        </aside>
    </section>
</main>
<footer class="site-footer"><div class="footer-grid"><div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div><div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div><div class="footer-col"><h4>Support</h4><a href="profile.php">Profile</a><a href="My_Bookings.php">My Bookings</a><a href="sign_up.php">Sign Up</a></div><div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div></div><div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div></footer>
<script src="seat-booking.js"></script>
</body>
</html>
