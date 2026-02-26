<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
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
        <h3>Manage Events</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        <div class="admin-actions fixed-bottom-left">
            <a class="action-btn add-event-btn" href="add-event.php">Add Event</a>
            <a class="action-btn add-movie-btn" href="add-movie.php">Add Movie</a>
        </div>

<div class="card" style="padding: 0;">
    <h3 style="padding: 22px 22px 10px 22px;">All Events</h3>
    <table style="border: none; border-radius: 0; box-shadow: none;">
    <tr><th>ID</th><th>Event Name</th><th>Category</th><th>Date</th><th>Actions</th></tr>
    <tr>
        <td>1</td><td>Avengers</td><td>Movie</td><td>20 Dec</td>
        <td class="actions-cell">
            <a href="#" class="btn-icon btn-edit" title="Edit">✎</a>
            <a href="#" class="btn-icon btn-delete" title="Delete">🗑</a>
        </td>
    </tr>
    <tr>
        <td>2</td><td>Comedy Night</td><td>Stand-up</td><td>25 Dec</td>
        <td class="actions-cell">
            <a href="#" class="btn-icon btn-edit" title="Edit">✎</a>
            <a href="#" class="btn-icon btn-delete" title="Delete">🗑</a>
        </td>
    </tr>
    </table>
</div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>

