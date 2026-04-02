<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

$bookings = fetch_all_bookings();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="logo">TicketVerse</div>
    <a href="index1.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php" class="active">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>
<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>
        <h3>Bookings</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>
    <div class="page-content">
        <h3>All Bookings</h3>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Show</th>
                    <th>Type</th>
                    <th>Seats</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= (int) $booking['id'] ?></td>
                        <td><?= e($booking['full_name']) ?> (<?= e($booking['login_user_id']) ?>)</td>
                        <td><?= e($booking['show_name']) ?><br><small><?= e($booking['venue']) ?></small></td>
                        <td><?= e(ucfirst((string) $booking['booking_type'])) ?></td>
                        <td><?= e($booking['seats']) ?></td>
                        <td>INR <?= number_format((float) $booking['total_amount'], 0) ?></td>
                        <td><?= e(ucfirst((string) $booking['booking_status'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
