<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo">🎟 TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php" class="active">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Users</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
    
<div class="card" style="padding: 0;">
    <h3 style="padding: 22px 22px 10px 22px;">All Users</h3>
    <table style="border: none; border-radius: 0; box-shadow: none;">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Actions</th></tr>
    <tr>
        <td>1</td><td>Krish</td><td>krish@email.com</td>
        <td><span class="badge badge-success">Active</span></td>
        <td class="actions-cell">
            <a href="#" class="btn-icon btn-edit" title="Edit">✎</a>
            <a href="#" class="btn-icon btn-delete" title="Delete">🗑</a>
        </td>
    </tr>
    <tr>
        <td>2</td><td>Rahul</td><td>rahul@email.com</td>
        <td><span class="badge badge-success">Active</span></td>
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

