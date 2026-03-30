<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    create_venue([
        'city' => $_POST['venue_city'] ?? '',
        'name' => $_POST['venue_name'] ?? '',
        'area' => $_POST['venue_area'] ?? '',
        'features' => $_POST['venue_features'] ?? '',
    ]);

    header('Location: events.php?message=venue-added');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Venue</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add-venue.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="venue-page-bg">
<div class="sidebar" id="sidebar">
    <div class="logo">TicketVerse</div>
    <a href="index1.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Add Venue</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content venue-form-card">
        <h2 class="section-title">Create New Venue</h2>
        <form class="form-card venue-form" method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label for="venue_city">City</label>
                    <input type="text" id="venue_city" name="venue_city" placeholder="Surat" required>
                </div>
                <div class="form-group">
                    <label for="venue_name">Venue Name</label>
                    <input type="text" id="venue_name" name="venue_name" placeholder="INOX: VR Mall" required>
                </div>
                <div class="form-group full-width">
                    <label for="venue_area">Area</label>
                    <input type="text" id="venue_area" name="venue_area" placeholder="Dumas Road, Surat">
                </div>
                <div class="form-group full-width">
                    <label for="venue_features">Features</label>
                    <input type="text" id="venue_features" name="venue_features" placeholder="Parking, Food Court, Recliner">
                </div>
                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Venue</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
