<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: Sign_in.php?error=Please%20sign%20in%20as%20admin');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index1.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Dashboard</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        <div class="admin-actions fixed-bottom-left">
            <a class="action-btn add-event-btn" href="add-event.php">Add Event</a>
            <a class="action-btn add-movie-btn" href="add-movie.php">Add Movie</a>
        </div>

<div class="cards">
    <div class="card"><h4>Total Events</h4><h2>2</h2></div>
    <div class="card"><h4>Total Bookings</h4><h2>5</h2></div>
    <div class="card"><h4>Total Revenue</h4><h2>₹85,000</h2></div>
    <div class="card"><h4>Total Users</h4><h2>2</h2></div>
</div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>

