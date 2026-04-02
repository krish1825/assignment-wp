<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: Sign_in.php?error=Please%20sign%20in%20as%20admin');
    exit;
}

require_once 'db.php'; 

// Fetch total events (events + movies)
$event_count_stmt = $conn->query("SELECT COUNT(*) FROM events");
$movie_count_stmt = $conn->query("SELECT COUNT(*) FROM movies");
$total_events = (int) $event_count_stmt->fetchColumn() + (int) $movie_count_stmt->fetchColumn();

// Fetch total users
$stmt = $conn->query("SELECT COUNT(*) FROM users");
$total_users = $stmt->fetchColumn();

// Fetch total bookings
$stmt = $conn->query("SELECT COUNT(*) FROM bookings");
$total_bookings = $stmt->fetchColumn();

// Fetch total revenue from confirmed and upcoming bookings
$stmt = $conn->query("
    SELECT COALESCE(SUM(total_amount), 0)
    FROM bookings
    WHERE booking_status IN ('confirmed', 'upcoming')
");
$total_revenue = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADMIN | Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index1.php" class="active">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Dashboard</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        <div class="admin-actions fixed-bottom-left">
            <a class="action-btn add-event-btn" href="add-event.php">Add Event</a>
            <a class="action-btn add-movie-btn" href="add-movie.php">Add Movie</a>
        </div>

<div class="cards">
    <div class="card"><h4>Total Events</h4><h2><?php echo $total_events; ?></h2></div>
    <div class="card"><h4>Total Bookings</h4><h2><?php echo $total_bookings; ?></h2></div>
    <div class="card"><h4>Total Revenue</h4><h2>₹<?php echo number_format($total_revenue, 2); ?></h2></div>
    <div class="card"><h4>Total Users</h4><h2><?php echo $total_users; ?></h2></div>
</div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>

