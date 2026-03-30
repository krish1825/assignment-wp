<<<<<<< HEAD
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
=======
<?php require_once 'session_check.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_title'])) {
    $title = $_POST['movie_title'];
    $genre = $_POST['movie_genre'];
    $date = $_POST['movie_date'];
    $duration = $_POST['movie_duration'];
    $language = $_POST['movie_language'];
    $description = $_POST['movie_description'];
    $price = $_POST['movie_price'];
    $shows = $_POST['movie_shows'];
    
    $photo = '';
    if (isset($_FILES['movie_photo']) && $_FILES['movie_photo']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir);
        $photo = time() . '_' . basename($_FILES['movie_photo']['name']);
        move_uploaded_file($_FILES['movie_photo']['tmp_name'], $upload_dir . $photo);
    }

    $stmt = $conn->prepare("INSERT INTO movies (title, genre, release_date, duration, language, description, photo, price, shows_per_day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $genre, $date, $duration, $language, $description, $photo, $price, $shows]);
    
    header("Location: events.php");
>>>>>>> 38d872e849e51c68b1bbb737b8fc11198aaccacf
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
    <a href="events.php" class="active">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="Sign_in.php?logout=true">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Add Movie</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content movie-form-card">
        <h2 class="section-title">Add New Movie</h2>
<<<<<<< HEAD
        <form class="form-card movie-form" method="post" enctype="multipart/form-data">
=======
        <form class="form-card movie-form" id="movieForm" action="add-movie.php" method="post" enctype="multipart/form-data" novalidate>
>>>>>>> 38d872e849e51c68b1bbb737b8fc11198aaccacf
            <div class="form-grid">
                <div class="form-group">
                    <label for="movie_title">Movie Title</label>
                    <input type="text" id="movie_title" name="movie_title" placeholder="Avengers">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="movie_genre">Genre</label>
                    <select id="movie_genre" name="movie_genre">
                        <option value="">Select Genre</option>
                        <option value="action">Action</option>
                        <option value="drama">Drama</option>
                        <option value="comedy">Comedy</option>
                        <option value="thriller">Thriller</option>
                        <option value="animation">Animation</option>
                    </select>
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="movie_date">Release Date</label>
                    <input type="date" id="movie_date" name="movie_date">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="movie_duration">Duration (minutes)</label>
                    <input type="number" id="movie_duration" name="movie_duration" min="1" placeholder="120">
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="movie_language">Language</label>
                    <input type="text" id="movie_language" name="movie_language" placeholder="English, Hindi">
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="movie_description">Description</label>
                    <textarea id="movie_description" name="movie_description" placeholder="Write movie details"></textarea>
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="movie_photo">Add Photo</label>
                    <input type="file" id="movie_photo" name="movie_photo" accept="image/*">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="movie_price">Ticket Price</label>
                    <input type="number" id="movie_price" name="movie_price" min="0" placeholder="299">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="movie_shows">Shows Per Day</label>
                    <input type="number" id="movie_shows" name="movie_shows" min="1" placeholder="5">
                    <small class="error-message"></small>
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

<<<<<<< HEAD
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
=======
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
>>>>>>> 38d872e849e51c68b1bbb737b8fc11198aaccacf
<script src="script.js"></script>
<script>
    $(function () {
        var $form = $("#movieForm");

        function setError($field, message) {
            $field.addClass("has-error");
            $field.closest(".form-group").find(".error-message").text(message);
        }

        function clearError($field) {
            $field.removeClass("has-error");
            $field.closest(".form-group").find(".error-message").text("");
        }

        function validateTitle() {
            var $field = $("#movie_title");
            var value = $.trim($field.val());
            if (value.length < 2) {
                setError($field, "Movie title must be at least 2 characters.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateGenre() {
            var $field = $("#movie_genre");
            if ($.trim($field.val()) === "") {
                setError($field, "Please select a genre.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateDate() {
            var $field = $("#movie_date");
            if ($.trim($field.val()) === "") {
                setError($field, "Please select a release date.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateDuration() {
            var $field = $("#movie_duration");
            var value = $.trim($field.val());
            if (value === "" || isNaN(value) || Number(value) < 1) {
                setError($field, "Duration must be at least 1 minute.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateLanguage() {
            var $field = $("#movie_language");
            var value = $.trim($field.val());
            if (value.length < 2) {
                setError($field, "Language is required.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateDescription() {
            var $field = $("#movie_description");
            var value = $.trim($field.val());
            if (value === "") {
                setError($field, "Description is required.");
                return false;
            }
            if (value.length < 10) {
                setError($field, "Description must be at least 10 characters.");
                return false;
            }
            if (value.length > 500) {
                setError($field, "Description must be less than 500 characters.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validatePhoto() {
            var $field = $("#movie_photo");
            var file = $field[0].files[0];
            if (!file) {
                setError($field, "Photo is required.");
                return false;
            }
            if (file && file.type.indexOf("image/") !== 0) {
                setError($field, "Please upload a valid image file.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validatePrice() {
            var $field = $("#movie_price");
            var value = $.trim($field.val());
            if (value === "" || isNaN(value) || Number(value) < 0) {
                setError($field, "Price must be 0 or greater.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateShows() {
            var $field = $("#movie_shows");
            var value = $.trim($field.val());
            if (value === "" || isNaN(value) || Number(value) < 1) {
                setError($field, "Shows per day must be at least 1.");
                return false;
            }
            clearError($field);
            return true;
        }

        $("#movie_title").on("input blur", validateTitle);
        $("#movie_genre").on("change blur", validateGenre);
        $("#movie_date").on("change blur", validateDate);
        $("#movie_duration").on("input blur", validateDuration);
        $("#movie_language").on("input blur", validateLanguage);
        $("#movie_description").on("input blur", validateDescription);
        $("#movie_photo").on("change blur", validatePhoto);
        $("#movie_price").on("input blur", validatePrice);
        $("#movie_shows").on("input blur", validateShows);

        $form.on("submit", function (event) {
            var isValid = [
                validateTitle(),
                validateGenre(),
                validateDate(),
                validateDuration(),
                validateLanguage(),
                validateDescription(),
                validatePhoto(),
                validatePrice(),
                validateShows()
            ].every(Boolean);

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
</body>
</html>
