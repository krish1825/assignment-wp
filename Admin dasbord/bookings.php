<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Bookings</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        
<h3>All Bookings</h3>
<table>
<tr><th>ID</th><th>User</th><th>Event</th><th>Seats</th><th>Status</th></tr>
<tr><td>1</td><td>Krish</td><td>Avengers</td><td>2</td><td>Confirmed</td></tr>
<tr><td>2</td><td>Rahul</td><td>Comedy Night</td><td>4</td><td>Pending</td></tr>
</table>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>

