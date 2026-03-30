<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

$scheduleCatalog = movie_schedule_catalog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagePath = store_uploaded_image($_FILES['movie_photo'] ?? [], 'movie');
    $schedulePayload = json_decode((string) ($_POST['movie_schedule_payload'] ?? '[]'), true);

    create_movie([
        'title' => $_POST['movie_title'] ?? '',
        'genre' => $_POST['movie_genre'] ?? '',
        'release_date' => $_POST['movie_date'] ?? date('Y-m-d'),
        'duration_minutes' => $_POST['movie_duration'] ?? 0,
        'language' => $_POST['movie_language'] ?? '',
        'description' => $_POST['movie_description'] ?? '',
        'ticket_price' => $_POST['movie_price'] ?? 0,
        'shows_per_day' => $_POST['movie_shows'] ?? 1,
        'image_path' => $imagePath,
        'schedules' => is_array($schedulePayload) ? $schedulePayload : [],
    ]);

    header('Location: events.php?message=movie-added');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add-movie.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="movie-page-bg">
<div class="sidebar" id="sidebar">
    <div class="logo">TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Add Movie</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content movie-form-card">
        <h2 class="section-title">Add New Movie</h2>
        <form class="form-card movie-form" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="movie_title">Movie Title</label>
                    <input type="text" id="movie_title" name="movie_title" placeholder="Avengers" required>
                </div>
                <div class="form-group">
                    <label for="movie_genre">Genre</label>
                    <select id="movie_genre" name="movie_genre" required>
                        <option value="">Select Genre</option>
                        <option value="action">Action</option>
                        <option value="drama">Drama</option>
                        <option value="comedy">Comedy</option>
                        <option value="thriller">Thriller</option>
                        <option value="animation">Animation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="movie_date">Release Date</label>
                    <input type="date" id="movie_date" name="movie_date" required>
                </div>
                <div class="form-group">
                    <label for="movie_duration">Duration (minutes)</label>
                    <input type="number" id="movie_duration" name="movie_duration" min="1" placeholder="120" required>
                </div>
                <div class="form-group full-width">
                    <label for="movie_language">Language</label>
                    <input type="text" id="movie_language" name="movie_language" placeholder="English, Hindi" required>
                </div>
                <div class="form-group full-width">
                    <label for="movie_description">Description</label>
                    <textarea id="movie_description" name="movie_description" placeholder="Write movie details"></textarea>
                </div>
                <div class="form-group full-width">
                    <label for="movie_photo">Add Photo</label>
                    <input type="file" id="movie_photo" name="movie_photo" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="movie_price">Ticket Price</label>
                    <input type="number" id="movie_price" name="movie_price" min="0" placeholder="299" required>
                </div>
                <div class="form-group">
                    <label for="movie_shows">Shows Per Day</label>
                    <input type="number" id="movie_shows" name="movie_shows" min="1" placeholder="5" required>
                </div>

                <div class="form-group full-width schedule-builder">
                    <div class="schedule-heading">
                        <div>
                            <label class="schedule-title" for="schedule_city">Cities, Venues, Screens and Show Timings</label>
                            <p class="schedule-help">Choose from more cities and venue-specific screen sizes, then add one or more time slots for this movie.</p>
                        </div>
                        <span class="schedule-count" id="scheduleCount">0 slots added</span>
                    </div>

                    <input type="hidden" id="movie_schedule_payload" name="movie_schedule_payload" value="[]">

                    <div class="schedule-controls">
                        <div class="form-group">
                            <label for="schedule_city">City</label>
                            <select id="schedule_city"></select>
                        </div>
                        <div class="form-group">
                            <label for="schedule_venue">Venue</label>
                            <select id="schedule_venue"></select>
                        </div>
                        <div class="form-group">
                            <label for="schedule_screen">Screen Size</label>
                            <select id="schedule_screen"></select>
                        </div>
                        <div class="form-group">
                            <label>Available Show Timings</label>
                            <div class="timing-options" id="timingOptions"></div>
                        </div>
                    </div>

                    <div class="custom-venue-builder">
                        <div class="form-group">
                            <label for="custom_city">New City</label>
                            <input type="text" id="custom_city" placeholder="Surat">
                        </div>
                        <div class="form-group">
                            <label for="custom_venue">New Venue</label>
                            <input type="text" id="custom_venue" placeholder="INOX: VR Mall">
                        </div>
                        <div class="form-group">
                            <label for="custom_area">Area</label>
                            <input type="text" id="custom_area" placeholder="Dumas Road, Surat">
                        </div>
                        <div class="form-group button-group">
                            <label>&nbsp;</label>
                            <button type="button" class="submit-btn city-venue-btn" id="addCityVenueBtn">Add City & Venue</button>
                        </div>
                    </div>

                    <div class="venue-preview" id="venuePreview">Select a venue to preview supported screen formats and timing bands.</div>

                    <div class="schedule-actions">
                        <button type="button" class="submit-btn secondary-btn" id="addScheduleBtn">Add Selected Slots</button>
                        <span class="schedule-note">Tip: the shows-per-day field updates automatically as you add or remove slots.</span>
                    </div>

                    <div class="schedule-list" id="scheduleList">
                        <div class="empty-schedule" id="emptyScheduleState">No show schedules added yet.</div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Movie</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    var scheduleCatalog = <?= json_encode($scheduleCatalog, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    var citySelect = document.getElementById('schedule_city');
    var venueSelect = document.getElementById('schedule_venue');
    var screenSelect = document.getElementById('schedule_screen');
    var timingOptions = document.getElementById('timingOptions');
    var addScheduleBtn = document.getElementById('addScheduleBtn');
    var addCityVenueBtn = document.getElementById('addCityVenueBtn');
    var scheduleList = document.getElementById('scheduleList');
    var emptyScheduleState = document.getElementById('emptyScheduleState');
    var payloadInput = document.getElementById('movie_schedule_payload');
    var scheduleCount = document.getElementById('scheduleCount');
    var venuePreview = document.getElementById('venuePreview');
    var showsInput = document.getElementById('movie_shows');
    var customCityInput = document.getElementById('custom_city');
    var customVenueInput = document.getElementById('custom_venue');
    var customAreaInput = document.getElementById('custom_area');
    var schedules = [];

    function defaultScreenTemplates() {
        return [
            { type: 'Standard', times: ['10:00 AM', '01:30 PM', '05:00 PM', '08:30 PM'] },
            { type: 'Premium', times: ['11:15 AM', '02:45 PM', '06:15 PM', '09:45 PM'] },
            { type: 'IMAX', times: ['12:00 PM', '03:30 PM', '07:00 PM', '10:15 PM'] }
        ];
    }

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

    function showLabelForTime(time) {
        var hourMatch = time.match(/^(\d{1,2})/);
        var meridiemMatch = time.match(/(AM|PM)$/i);
        var hour = hourMatch ? parseInt(hourMatch[1], 10) : 0;
        var meridiem = meridiemMatch ? meridiemMatch[1].toUpperCase() : 'AM';

        if (meridiem === 'PM' && hour !== 12) hour += 12;
        if (meridiem === 'AM' && hour === 12) hour = 0;

        if (hour < 12) return 'Morning Show';
        if (hour < 16) return 'Matinee Show';
        if (hour < 20) return 'Evening Show';
        return 'Night Show';
    }

    function populateCities() {
        citySelect.innerHTML = scheduleCatalog.map(function (item) {
            return '<option value="' + item.city + '">' + item.city + '</option>';
        }).join('');
        populateVenues();
    }

    function populateVenues() {
        var cityBlock = getCityBlock(citySelect.value);
        if (!cityBlock) {
            venueSelect.innerHTML = '';
            populateScreens();
            return;
        }

        venueSelect.innerHTML = cityBlock.venues.map(function (venue) {
            return '<option value="' + venue.name + '">' + venue.name + '</option>';
        }).join('');
        populateScreens();
    }

    function populateScreens() {
        var venueBlock = getVenueBlock(citySelect.value, venueSelect.value);
        if (!venueBlock) {
            screenSelect.innerHTML = '';
            renderTimings();
            return;
        }

        screenSelect.innerHTML = venueBlock.screens.map(function (screen) {
            return '<option value="' + screen.type + '">' + screen.type + '</option>';
        }).join('');
        renderVenuePreview();
        renderTimings();
    }

    function renderVenuePreview() {
        var venueBlock = getVenueBlock(citySelect.value, venueSelect.value);
        if (!venueBlock) {
            venuePreview.textContent = 'Select a venue to preview supported screen formats and timing bands.';
            return;
        }

        var formats = venueBlock.screens.map(function (screen) {
            return screen.type;
        }).join(', ');
        var features = venueBlock.features.join(', ');
        venuePreview.textContent = venueBlock.area + ' | Formats: ' + formats + ' | Amenities: ' + features;
    }

    function renderTimings() {
        var screenBlock = getScreenBlock(citySelect.value, venueSelect.value, screenSelect.value);
        if (!screenBlock) {
            timingOptions.innerHTML = '<div class="timing-empty">No timings available for this combination.</div>';
            return;
        }

        timingOptions.innerHTML = screenBlock.times.map(function (time, index) {
            return '<label class="timing-chip" for="timing_' + index + '">' +
                '<input type="checkbox" id="timing_' + index + '" value="' + time + '">' +
                '<span>' + time + '</span>' +
                '<small>' + showLabelForTime(time) + '</small>' +
            '</label>';
        }).join('');
    }

    function syncPayload() {
        payloadInput.value = JSON.stringify(schedules);
        scheduleCount.textContent = schedules.length + (schedules.length === 1 ? ' slot added' : ' slots added');
        if (schedules.length > 0) {
            showsInput.value = schedules.length;
        }
    }

    function renderSchedules() {
        if (schedules.length === 0) {
            emptyScheduleState.style.display = 'block';
            scheduleList.innerHTML = '';
            scheduleList.appendChild(emptyScheduleState);
            syncPayload();
            return;
        }

        emptyScheduleState.style.display = 'none';
        scheduleList.innerHTML = schedules.map(function (schedule, index) {
            return '<div class="schedule-item">' +
                '<div>' +
                    '<strong>' + schedule.city + ' | ' + schedule.venue + '</strong>' +
                    '<p>' + schedule.screen_type + ' | ' + schedule.show_time + ' | ' + showLabelForTime(schedule.show_time) + '</p>' +
                '</div>' +
                '<button type="button" class="remove-schedule-btn" data-index="' + index + '">Remove</button>' +
            '</div>';
        }).join('');

        Array.prototype.slice.call(scheduleList.querySelectorAll('.remove-schedule-btn')).forEach(function (button) {
            button.addEventListener('click', function () {
                var index = parseInt(button.getAttribute('data-index'), 10);
                schedules.splice(index, 1);
                renderSchedules();
            });
        });

        syncPayload();
    }

    function addSelectedSchedules() {
        var checkedTimings = Array.prototype.slice.call(timingOptions.querySelectorAll('input[type="checkbox"]:checked'));
        if (checkedTimings.length === 0) {
            return;
        }

        checkedTimings.forEach(function (checkbox) {
            var schedule = {
                city: citySelect.value,
                venue: venueSelect.value,
                screen_type: screenSelect.value,
                show_time: checkbox.value
            };
            var exists = schedules.some(function (item) {
                return item.city === schedule.city && item.venue === schedule.venue && item.screen_type === schedule.screen_type && item.show_time === schedule.show_time;
            });
            if (!exists) {
                schedules.push(schedule);
            }
            checkbox.checked = false;
        });

        renderSchedules();
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
    screenSelect.addEventListener('change', renderTimings);
    addScheduleBtn.addEventListener('click', addSelectedSchedules);
    addCityVenueBtn.addEventListener('click', addCityVenueOption);

    populateCities();
    renderSchedules();
})();
</script>
<script src="script.js"></script>
</body>
</html>
