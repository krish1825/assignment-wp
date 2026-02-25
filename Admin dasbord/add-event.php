<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .event-page-bg {
            background:
                radial-gradient(circle at 0% 20%, rgba(14, 165, 233, 0.12) 0, transparent 42%),
                radial-gradient(circle at 100% 90%, rgba(2, 132, 199, 0.1) 0, transparent 38%),
                linear-gradient(165deg, #f7f9ff, #dfe9ff);
        }

        .event-form-card {
            border: 1px solid #d6e0f5;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }

        .event-form-card .section-title {
            color: #0369a1;
            letter-spacing: 0.2px;
            margin-bottom: 18px;
        }

        .event-form {
            max-width: 980px;
            border: 1px solid #d6e0f5;
            box-shadow: 0 8px 22px rgba(2, 132, 199, 0.1);
            background: linear-gradient(180deg, #ffffff, #f7faff);
            padding: 24px;
            border-radius: 14px;
        }

        .event-form .form-grid {
            gap: 18px;
        }

        .event-form .form-group label {
            color: #0f172a;
            font-weight: 700;
            margin-bottom: 7px;
        }

        @media (max-width: 768px) {
            .event-form-card {
                border-radius: 12px;
                padding: 18px;
            }

            .event-form {
                padding: 16px;
            }

            .event-form-card .section-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body class="event-page-bg">
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
        <h3>Add Event</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content event-form-card">
        <h2 class="section-title">Create New Event</h2>
        <form class="form-card event-form" action="events.php" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" placeholder="Comedy Night" required>
                </div>
                <div class="form-group">
                    <label for="event_category">Category</label>
                    <select id="event_category" name="event_category" required>
                        <option value="">Select Category</option>
                        <option value="standup">Stand-up</option>
                        <option value="concert">Concert</option>
                        <option value="sports">Sports</option>
                        <option value="theatre">Theatre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event_date">Date</label>
                    <input type="date" id="event_date" name="event_date" required>
                </div>
                <div class="form-group">
                    <label for="event_time">Time</label>
                    <input type="time" id="event_time" name="event_time" required>
                </div>
                <div class="form-group full-width">
                    <label for="event_location">Location</label>
                    <input type="text" id="event_location" name="event_location" placeholder="Mumbai Arena" required>
                </div>
                <div class="form-group full-width">
                    <label for="event_description">Description</label>
                    <textarea id="event_description" name="event_description" placeholder="Write event details"></textarea>
                </div>
                <div class="form-group full-width">
                    <label for="event_photo">Add Photo</label>
                    <input type="file" id="event_photo" name="event_photo" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="event_price">Ticket Price</label>
                    <input type="number" id="event_price" name="event_price" min="0" placeholder="999" required>
                </div>
                <div class="form-group">
                    <label for="event_seats">Available Seats</label>
                    <input type="number" id="event_seats" name="event_seats" min="1" placeholder="200" required>
                </div>
                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

