<?php require_once 'session_check.php'; 

// Fetch total events (events + movies)
$stmt = $conn->query("SELECT (SELECT COUNT(*) FROM events) + (SELECT COUNT(*) FROM movies) as total");
$total_events = $stmt->fetchColumn();

// Fetch total users
$stmt = $conn->query("SELECT COUNT(*) FROM users");
$total_users = $stmt->fetchColumn();

// Fetch total bookings
$stmt = $conn->query("SELECT COUNT(*) FROM bookings");
$total_bookings = $stmt->fetchColumn();

// Fetch total revenue
$stmt = $conn->query("
    SELECT IFNULL(SUM(cases.total), 0) as revenue FROM (
        SELECT b.seats * e.price as total FROM bookings b JOIN events e ON b.event_id = e.id WHERE b.event_type = 'Event' AND b.status = 'Confirmed'
        UNION ALL
        SELECT b.seats * m.price as total FROM bookings b JOIN movies m ON b.event_id = m.id WHERE b.event_type = 'Movie' AND b.status = 'Confirmed'
    ) as cases
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
    <a href="index.php" class="active">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="Sign_in.php?logout=true">Logout</a>
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

