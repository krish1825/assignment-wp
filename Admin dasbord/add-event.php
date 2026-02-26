<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add-event.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="event-page-bg">
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
        <h3>Add Event</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content event-form-card">
        <h2 class="section-title">Create New Event</h2>
        <form class="form-card event-form" id="eventForm" action="events.php" method="post" enctype="multipart/form-data" novalidate>
            <div class="form-grid">
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" placeholder="Comedy Night">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="event_category">Category</label>
                    <select id="event_category" name="event_category">
                        <option value="">Select Category</option>
                        <option value="standup">Stand-up</option>
                        <option value="concert">Concert</option>
                        <option value="sports">Sports</option>
                        <option value="theatre">Theatre</option>
                    </select>
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="event_date">Date</label>
                    <input type="date" id="event_date" name="event_date">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="event_time">Time</label>
                    <input type="time" id="event_time" name="event_time">
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="event_location">Location</label>
                    <input type="text" id="event_location" name="event_location" placeholder="Mumbai Arena">
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="event_description">Description</label>
                    <textarea id="event_description" name="event_description" placeholder="Write event details"></textarea>
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <label for="event_photo">Add Photo</label>
                    <input type="file" id="event_photo" name="event_photo" accept="image/*">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="event_price">Ticket Price</label>
                    <input type="number" id="event_price" name="event_price" min="0" placeholder="999">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="event_seats">Available Seats</label>
                    <input type="number" id="event_seats" name="event_seats" min="1" placeholder="200">
                    <small class="error-message"></small>
                </div>
                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="script.js"></script>
<script>
    $(function () {
        var $form = $("#eventForm");

        function setError($field, message) {
            $field.addClass("has-error");
            $field.closest(".form-group").find(".error-message").text(message).css({
                color: "#ff0000",
                fontWeight: "600"
            });
        }

        function clearError($field) {
            $field.removeClass("has-error");
            $field.closest(".form-group").find(".error-message").text("");
        }

        function validateName() {
            var $field = $("#event_name");
            var value = $.trim($field.val());
            if (value.length < 3) {
                setError($field, "Event name must be at least 3 characters.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateCategory() {
            var $field = $("#event_category");
            if ($.trim($field.val()) === "") {
                setError($field, "Please select a category.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateDate() {
            var $field = $("#event_date");
            var value = $.trim($field.val());
            if (value === "") {
                setError($field, "Please select an event date.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateTime() {
            var $field = $("#event_time");
            if ($.trim($field.val()) === "") {
                setError($field, "Please select an event time.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateLocation() {
            var $field = $("#event_location");
            var value = $.trim($field.val());
            if (value.length < 3) {
                setError($field, "Location must be at least 3 characters.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateDescription() {
            var $field = $("#event_description");
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
            var $field = $("#event_photo");
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
            var $field = $("#event_price");
            var value = $.trim($field.val());
            if (value === "" || isNaN(value) || Number(value) < 0) {
                setError($field, "Price must be 0 or greater.");
                return false;
            }
            clearError($field);
            return true;
        }

        function validateSeats() {
            var $field = $("#event_seats");
            var value = $.trim($field.val());
            if (value === "" || isNaN(value) || Number(value) < 1) {
                setError($field, "Seats must be at least 1.");
                return false;
            }
            clearError($field);
            return true;
        }

        $("#event_name").on("input blur", validateName);
        $("#event_category").on("change blur", validateCategory);
        $("#event_date").on("change blur", validateDate);
        $("#event_time").on("change blur", validateTime);
        $("#event_location").on("input blur", validateLocation);
        $("#event_description").on("input blur", validateDescription);
        $("#event_photo").on("change blur", validatePhoto);
        $("#event_price").on("input blur", validatePrice);
        $("#event_seats").on("input blur", validateSeats);

        $form.on("submit", function (event) {
            var isValid = [
                validateName(),
                validateCategory(),
                validateDate(),
                validateTime(),
                validateLocation(),
                validateDescription(),
                validatePhoto(),
                validatePrice(),
                validateSeats()
            ].every(Boolean);

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
</body>
</html>

