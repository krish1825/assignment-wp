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
$requestedDate = trim((string) ($_GET['date'] ?? ''));
$requestedCity = trim((string) ($_GET['city'] ?? 'Ahmedabad'));
$today = date('Y-m-d');
$bookingDate = $requestedDate !== '' && $requestedDate >= $today ? $requestedDate : $today;
$rawSchedules = fetch_movie_schedules_by_title($show);
$groupedVenues = [];

foreach ($rawSchedules as $schedule) {
    $city = trim((string) ($schedule['city'] ?? 'Ahmedabad'));
    $venue = trim((string) ($schedule['venue'] ?? ''));
    $screenType = trim((string) ($schedule['screen_type'] ?? 'Standard'));
    $showTime = trim((string) ($schedule['show_time'] ?? ''));

    if ($venue === '' || $showTime === '') {
        continue;
    }

    $details = catalog_venue_details($city, $venue);
    if (!isset($groupedVenues[$city][$venue])) {
        $groupedVenues[$city][$venue] = [
            'city' => $city,
            'venue' => $venue,
            'area' => (string) ($details['area'] ?? $city),
            'features' => array_values(array_unique(array_filter((array) ($details['features'] ?? [])))),
            'screen_types' => [],
            'shows' => [],
        ];
    }

    if (!in_array($screenType, $groupedVenues[$city][$venue]['screen_types'], true)) {
        $groupedVenues[$city][$venue]['screen_types'][] = $screenType;
    }

    $groupedVenues[$city][$venue]['shows'][] = [
        'time' => $showTime,
        'screen_type' => $screenType,
        'show_label' => movie_show_label_for_time($showTime),
    ];
}

$cityList = array_keys($groupedVenues);
$city = in_array($requestedCity, $cityList, true) ? $requestedCity : ($cityList[0] ?? 'Ahmedabad');
?>
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
    <form id="slotForm" action="seat-booking.php" method="get">
        <input type="hidden" name="show" id="selectedShowInput" value="<?= e($show) ?>">
        <input type="hidden" name="venue" id="selectedVenueInput" value="">
        <input type="hidden" name="time" id="selectedTimeInput" value="">
        <input type="hidden" name="city" id="selectedCityInput" value="<?= e($city) ?>">
        <section class="slot-hero">
            <div>
                <h1>Choose Venue and Time</h1>
                <p>Browse more cities, richer venue choices, and venue-specific screen formats for every show.</p>
                <span class="show-chip" id="selectedShowLabel">Now booking: <?= e($show) ?></span>
            </div>
            <div class="date-picker">
                <label for="showDate">Date</label>
                <input type="date" id="showDate" name="date" value="<?= e($bookingDate) ?>" min="<?= e($today) ?>">
            </div>
        </section>

        <section class="city-switch" id="citySwitch">
            <?php foreach ($cityList as $cityName): ?>
                <button type="button" class="city-pill<?= $city === $cityName ? ' active' : '' ?>" data-city="<?= e($cityName) ?>"><?= e($cityName) ?></button>
            <?php endforeach; ?>
        </section>

        <section class="venues-grid" id="venueGrid">
            <?php foreach ($groupedVenues as $cityName => $venues): ?>
                <?php foreach ($venues as $venueData): ?>
                    <article class="venue-card" data-city="<?= e($cityName) ?>" data-venue="<?= e($venueData['venue']) ?>">
                        <div class="venue-head">
                            <h3><?= e($venueData['venue']) ?></h3>
                            <p><?= e($venueData['area']) ?></p>
                        </div>
                        <div class="venue-meta">
                            <?php foreach ($venueData['screen_types'] as $screenType): ?>
                                <span><?= e($screenType) ?></span>
                            <?php endforeach; ?>
                            <?php foreach ($venueData['features'] as $feature): ?>
                                <span><?= e($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="times">
                            <?php foreach ($venueData['shows'] as $showData): ?>
                                <button type="button" class="time-btn" data-time="<?= e($showData['time']) ?>" data-screen="<?= e($showData['screen_type']) ?>" data-show-label="<?= e($showData['show_label']) ?>">
                                    <span><?= e($showData['time']) ?></span>
                                    <small><?= e($showData['screen_type']) ?></small>
                                    <em><?= e($showData['show_label']) ?></em>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </section>

        <aside class="selection-bar">
            <div class="selection-meta">
                <strong id="summaryShow"><?= e($show) ?></strong>
                <span id="summaryCity">City: <?= e($city) ?></span>
                <span id="summaryVenue">Venue: Not selected</span>
                <span id="summaryScreen">Screen: Not selected</span>
                <span id="summaryTime">Time: Not selected</span>
                <span id="summaryDate">Date: <?= e($bookingDate) ?></span>
            </div>
            <button id="continueBtn" type="submit" class="continue-btn" disabled>Continue To Seat Selection</button>
        </aside>
    </form>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="../assets/js/form-validation.js"></script>
<script src="time-slot-venue.js"></script>
</body>
</html>
