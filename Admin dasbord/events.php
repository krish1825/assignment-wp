<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';
require_once 'session_check.php';

$scheduleCatalog = movie_schedule_catalog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string) ($_POST['action'] ?? 'toggle-status'));
    $type = $_POST['type'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'toggle-status' && in_array($type, ['movie', 'event'], true) && $id > 0) {
        toggle_record_status($type, $id);
        header('Location: events.php?message=status-updated');
        exit;
    }

    if ($action === 'add-movie-show') {
        $movieId = (int) ($_POST['movie_id'] ?? 0);
        add_movie_schedule($movieId, [
            'city' => $_POST['schedule_city'] ?? '',
            'venue' => $_POST['schedule_venue'] ?? '',
            'screen_type' => $_POST['schedule_screen'] ?? '',
            'show_time' => $_POST['schedule_time'] ?? '',
        ]);
        header('Location: events.php?message=show-added');
        exit;
    }

    if ($action === 'remove-movie-show') {
        $movieId = (int) ($_POST['movie_id'] ?? 0);
        $scheduleId = (int) ($_POST['schedule_id'] ?? 0);
        delete_movie_schedule($movieId, $scheduleId);
        header('Location: events.php?message=show-removed');
        exit;
    }
}

<<<<<<< Updated upstream
=======
if (isset($_GET['delete_type']) && isset($_GET['id'])) {
    $type = $_GET['delete_type'];
    $id = (int)$_GET['id'];
    
    if ($type === 'event') {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($type === 'movie') {
        $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: events.php");
    exit;
}

>>>>>>> Stashed changes
$movies = fetch_movies(null, false);
$events = fetch_events(null, false);
$message = $_GET['message'] ?? '';
$movieIds = array_map(static function (array $movie): int {
    return (int) ($movie['id'] ?? 0);
}, $movies);
$movieSchedules = fetch_movie_schedules_grouped_by_movie($movieIds);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar" id="sidebar">
<<<<<<< Updated upstream
    <div class="logo">TicketVerse</div>
    <a href="index1.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
=======
<div class="logo">🎟 TicketVerse</div>
<a href="index.php">Dashboard</a>
<a href="events.php" class="active">Manage Events</a>
>>>>>>> Stashed changes
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="Sign_in.php?logout=true">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>
        <h3>Manage Events</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
<<<<<<< Updated upstream
        <div class="admin-actions fixed-bottom-left">
            <a class="action-btn add-event-btn" href="add-event.php">Add Event</a>
            <a class="action-btn add-movie-btn" href="add-movie.php">Add Movie</a>
        </div>

        <?php if ($message === 'movie-added'): ?>
            <div class="notice success-notice">Movie added successfully.</div>
        <?php elseif ($message === 'event-added'): ?>
            <div class="notice success-notice">Event added successfully.</div>
        <?php elseif ($message === 'status-updated'): ?>
            <div class="notice success-notice">Status updated successfully.</div>
        <?php elseif ($message === 'show-added'): ?>
            <div class="notice success-notice">Show slot added successfully.</div>
        <?php elseif ($message === 'show-removed'): ?>
            <div class="notice success-notice">Show slot removed successfully.</div>
        <?php endif; ?>
=======
<div class="admin-actions fixed-bottom-left">
    <a class="action-btn add-event-btn" href="add-event.php">Add Event</a>
    <a class="action-btn add-movie-btn" href="add-movie.php">Add Movie</a>
</div>

<?php if ($message === 'movie-added'): ?>
    <div class="notice success-notice">Movie added successfully.</div>
<?php elseif ($message === 'event-added'): ?>
    <div class="notice success-notice">Event added successfully.</div>
<?php elseif ($message === 'status-updated'): ?>
    <div class="notice success-notice">Status updated successfully.</div>
<?php elseif ($message === 'show-added'): ?>
    <div class="notice success-notice">Show slot added successfully.</div>
<?php elseif ($message === 'show-removed'): ?>
    <div class="notice success-notice">Show slot removed successfully.</div>
<?php endif; ?>
>>>>>>> Stashed changes

        <h3>All Movies</h3>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Movie Name</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <th>Price</th>
                    <th>Shows</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($movies as $movie): ?>
                    <?php $schedules = $movieSchedules[(int) $movie['id']] ?? []; ?>
                    <tr>
                        <td><?= (int) $movie['id'] ?></td>
                        <td>
                            <strong><?= e($movie['title']) ?></strong><br>
                            <small><?= e($movie['language']) ?> | <?= (int) $movie['duration_minutes'] ?> mins</small>
                        </td>
                        <td><?= e(ucfirst((string) $movie['genre'])) ?></td>
                        <td><?= e(date('d M Y', strtotime((string) $movie['release_date']))) ?></td>
                        <td>INR <?= number_format((float) $movie['ticket_price'], 0) ?></td>
                        <td><?= count($schedules) ?></td>
                        <td><span class="status-badge <?= e((string) $movie['status']) ?>"><?= e(ucfirst((string) $movie['status'])) ?></span></td>
                        <td>
                            <form method="post" class="status-form inline-action-form">
                                <input type="hidden" name="action" value="toggle-status">
                                <input type="hidden" name="type" value="movie">
                                <input type="hidden" name="id" value="<?= (int) $movie['id'] ?>">
                                <button type="submit" class="status-btn <?= ($movie['status'] ?? 'active') === 'active' ? 'deactivate-btn' : 'activate-btn' ?>">
                                    <?= ($movie['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="movie-detail-row">
                        <td colspan="8">
                            <div class="manage-panel">
                                <div class="manage-panel-header">
                                    <div>
                                        <h4>Manage Show Details</h4>
                                        <p>Control venue, timing, screen type, and total show slots for <?= e($movie['title']) ?>.</p>
                                    </div>
                                    <span class="panel-stat"><?= count($schedules) ?> active slots</span>
                                </div>

                                <div class="schedule-chip-list">
                                    <?php if ($schedules === []): ?>
                                        <div class="empty-inline-state">No shows added yet for this movie.</div>
                                    <?php else: ?>
                                        <?php foreach ($schedules as $schedule): ?>
                                            <div class="schedule-admin-chip">
                                                <div>
                                                    <strong><?= e($schedule['city']) ?> | <?= e($schedule['venue']) ?></strong>
                                                    <p><?= e($schedule['screen_type']) ?> | <?= e($schedule['show_time']) ?> | <?= e(movie_show_label_for_time((string) $schedule['show_time'])) ?></p>
                                                </div>
                                                <form method="post" class="inline-action-form">
                                                    <input type="hidden" name="action" value="remove-movie-show">
                                                    <input type="hidden" name="movie_id" value="<?= (int) $movie['id'] ?>">
                                                    <input type="hidden" name="schedule_id" value="<?= (int) $schedule['id'] ?>">
                                                    <button type="submit" class="mini-danger-btn">Remove</button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <form method="post" class="manage-form movie-schedule-form" data-movie-id="<?= (int) $movie['id'] ?>">
                                    <input type="hidden" name="action" value="add-movie-show">
                                    <input type="hidden" name="movie_id" value="<?= (int) $movie['id'] ?>">
                                    <div class="manage-form-grid">
                                        <div class="form-group">
                                            <label for="schedule_city_<?= (int) $movie['id'] ?>">City</label>
                                            <select id="schedule_city_<?= (int) $movie['id'] ?>" name="schedule_city" class="schedule-city" required></select>
                                        </div>
                                        <div class="form-group">
                                            <label for="schedule_venue_<?= (int) $movie['id'] ?>">Venue</label>
                                            <select id="schedule_venue_<?= (int) $movie['id'] ?>" name="schedule_venue" class="schedule-venue" required></select>
                                        </div>
                                        <div class="form-group">
                                            <label for="schedule_screen_<?= (int) $movie['id'] ?>">Screen</label>
                                            <select id="schedule_screen_<?= (int) $movie['id'] ?>" name="schedule_screen" class="schedule-screen" required></select>
                                        </div>
                                        <div class="form-group">
                                            <label for="schedule_time_<?= (int) $movie['id'] ?>">Show Time</label>
                                            <select id="schedule_time_<?= (int) $movie['id'] ?>" name="schedule_time" class="schedule-time" required></select>
                                        </div>
                                    </div>
                                    <div class="manage-custom-grid">
                                        <div class="form-group">
                                            <label for="custom_city_<?= (int) $movie['id'] ?>">New City</label>
                                            <input type="text" id="custom_city_<?= (int) $movie['id'] ?>" class="custom-city" placeholder="Surat">
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_venue_<?= (int) $movie['id'] ?>">New Venue</label>
                                            <input type="text" id="custom_venue_<?= (int) $movie['id'] ?>" class="custom-venue" placeholder="INOX: VR Mall">
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_area_<?= (int) $movie['id'] ?>">Area</label>
                                            <input type="text" id="custom_area_<?= (int) $movie['id'] ?>" class="custom-area" placeholder="Dumas Road, Surat">
                                        </div>
                                        <div class="form-group button-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="submit-btn city-venue-btn add-city-venue-btn">Add City & Venue</button>
                                        </div>
                                    </div>
                                    <div class="manage-form-footer">
                                        <p class="manage-hint">Pick a venue-specific screen and timing to add another show slot.</p>
                                        <button type="submit" class="submit-btn">Add Show Slot</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <h3 class="section-space">All Events</h3>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= (int) $event['id'] ?></td>
                        <td><?= e($event['name']) ?></td>
                        <td><?= e(ucfirst((string) $event['category'])) ?></td>
                        <td><?= e(date('d M Y', strtotime((string) $event['event_date']))) ?></td>
                        <td><?= e(date('h:i A', strtotime((string) $event['event_time']))) ?></td>
                        <td><?= e($event['location']) ?></td>
                        <td>INR <?= number_format((float) $event['ticket_price'], 0) ?></td>
                        <td><span class="status-badge <?= e((string) $event['status']) ?>"><?= e(ucfirst((string) $event['status'])) ?></span></td>
                        <td>
                            <form method="post" class="status-form inline-action-form">
                                <input type="hidden" name="action" value="toggle-status">
                                <input type="hidden" name="type" value="event">
                                <input type="hidden" name="id" value="<?= (int) $event['id'] ?>">
                                <button type="submit" class="status-btn <?= ($event['status'] ?? 'active') === 'active' ? 'deactivate-btn' : 'activate-btn' ?>">
                                    <?= ($event['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
(function () {
    var scheduleCatalog = <?= json_encode($scheduleCatalog, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    var forms = Array.prototype.slice.call(document.querySelectorAll('.movie-schedule-form'));

    function getCityBlock(city) {
        return scheduleCatalog.find(function (item) {
            return item.city === city;
        }) || null;
    }

    function getVenueBlock(city, venue) {
        var cityBlock = getCityBlock(city);
        if (!cityBlock) return null;
        return cityBlock.venues.find(function (item) {
            return item.name === venue;
        }) || null;
    }

    function getScreenBlock(city, venue, screenType) {
        var venueBlock = getVenueBlock(city, venue);
        if (!venueBlock) return null;
        return venueBlock.screens.find(function (item) {
            return item.type === screenType;
        }) || null;
    }

    forms.forEach(function (form) {
        var citySelect = form.querySelector('.schedule-city');
        var venueSelect = form.querySelector('.schedule-venue');
        var screenSelect = form.querySelector('.schedule-screen');
        var timeSelect = form.querySelector('.schedule-time');
        var customCityInput = form.querySelector('.custom-city');
        var customVenueInput = form.querySelector('.custom-venue');
        var customAreaInput = form.querySelector('.custom-area');
        var addCityVenueBtn = form.querySelector('.add-city-venue-btn');

        function defaultScreenTemplates() {
            return [
                { type: 'Standard', times: ['10:00 AM', '01:30 PM', '05:00 PM', '08:30 PM'] },
                { type: 'Premium', times: ['11:15 AM', '02:45 PM', '06:15 PM', '09:45 PM'] },
                { type: 'IMAX', times: ['12:00 PM', '03:30 PM', '07:00 PM', '10:15 PM'] }
            ];
        }

        function populateCities() {
            citySelect.innerHTML = scheduleCatalog.map(function (item) {
                return '<option value="' + item.city + '">' + item.city + '</option>';
            }).join('');
            populateVenues();
        }

        function populateVenues() {
            var cityBlock = getCityBlock(citySelect.value);
            venueSelect.innerHTML = cityBlock ? cityBlock.venues.map(function (venue) {
                return '<option value="' + venue.name + '">' + venue.name + '</option>';
            }).join('') : '';
            populateScreens();
        }

        function populateScreens() {
            var venueBlock = getVenueBlock(citySelect.value, venueSelect.value);
            screenSelect.innerHTML = venueBlock ? venueBlock.screens.map(function (screen) {
                return '<option value="' + screen.type + '">' + screen.type + '</option>';
            }).join('') : '';
            populateTimes();
        }

        function populateTimes() {
            var screenBlock = getScreenBlock(citySelect.value, venueSelect.value, screenSelect.value);
            timeSelect.innerHTML = screenBlock ? screenBlock.times.map(function (time) {
                return '<option value="' + time + '">' + time + '</option>';
            }).join('') : '';
        }

        function addCityVenueOption() {
            var city = customCityInput.value.trim();
            var venue = customVenueInput.value.trim();
            var area = customAreaInput.value.trim();

            if (!city || !venue) {
                return;
            }

            var cityBlock = getCityBlock(city);
            if (!cityBlock) {
                cityBlock = {
                    city: city,
                    venues: []
                };
                scheduleCatalog.push(cityBlock);
            }

            var exists = cityBlock.venues.some(function (item) {
                return item.name.toLowerCase() === venue.toLowerCase();
            });

            if (!exists) {
                cityBlock.venues.push({
                    name: venue,
                    area: area || city,
                    features: ['Parking', 'Snacks', 'New Venue'],
                    screens: defaultScreenTemplates()
                });
            }

            populateCities();
            citySelect.value = city;
            populateVenues();
            venueSelect.value = venue;
            populateScreens();

            customCityInput.value = '';
            customVenueInput.value = '';
            customAreaInput.value = '';
        }

        citySelect.addEventListener('change', populateVenues);
        venueSelect.addEventListener('change', populateScreens);
        screenSelect.addEventListener('change', populateTimes);
        addCityVenueBtn.addEventListener('click', addCityVenueOption);
        populateCities();
    });
})();
</script>
<script src="script.js"></script>
</body>
</html>
