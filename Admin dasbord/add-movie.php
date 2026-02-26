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
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Add Movie</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content movie-form-card">
        <h2 class="section-title">Add New Movie</h2>
        <form class="form-card movie-form" id="movieForm" action="events.php" method="post" enctype="multipart/form-data" novalidate>
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
                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Movie</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

