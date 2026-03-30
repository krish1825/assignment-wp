<?php require_once 'session_check.php'; 

if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'confirm') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Confirmed' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'cancel') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: bookings.php");
    exit;
}

$stmt = $conn->query("
    SELECT 
        b.id,
        u.full_name as user_name,
        CASE 
            WHEN b.event_type = 'Event' THEN e.event_name
            WHEN b.event_type = 'Movie' THEN m.title
        END as event_name,
        b.seats,
        b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    LEFT JOIN events e ON b.event_type = 'Event' AND b.event_id = e.id
    LEFT JOIN movies m ON b.event_type = 'Movie' AND b.event_id = m.id
    ORDER BY b.created_at DESC
");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <div class="logo">🎟 TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php" class="active">Bookings</a>
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="Sign_in.php?logout=true">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h3>Bookings</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        
<div class="card" style="padding: 0;">
    <h3 style="padding: 22px 22px 10px 22px;">All Bookings</h3>
    <table style="border: none; border-radius: 0; box-shadow: none;">
    <tr><th>ID</th><th>User</th><th>Event</th><th>Seats</th><th>Status</th><th>Actions</th></tr>
    <?php if (empty($bookings)): ?>
    <tr><td colspan="6" style="text-align: center;">No bookings found.</td></tr>
    <?php else: ?>
        <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?php echo htmlspecialchars($b['id']); ?></td>
            <td><?php echo htmlspecialchars($b['user_name']); ?></td>
            <td><?php echo htmlspecialchars($b['event_name']); ?></td>
            <td><?php echo htmlspecialchars($b['seats']); ?></td>
            <td>
                <?php 
                    $badge_class = 'warning';
                    if ($b['status'] === 'Confirmed') $badge_class = 'success';
                    elseif ($b['status'] === 'Cancelled') $badge_class = 'danger'; // Assuming .badge-danger exists or falls back
                ?>
                <span class="badge badge-<?php echo $badge_class; ?>"><?php echo htmlspecialchars($b['status']); ?></span>
            </td>
            <td class="actions-cell">
                <?php if ($b['status'] === 'Pending'): ?>
                    <a href="bookings.php?action=confirm&id=<?php echo $b['id']; ?>" class="btn-icon btn-edit" title="Confirm" style="color: green;">✓</a>
                    <a href="bookings.php?action=cancel&id=<?php echo $b['id']; ?>" class="btn-icon btn-edit" title="Cancel" style="color: orange;">✕</a>
                <?php endif; ?>
                <a href="bookings.php?action=delete&id=<?php echo $b['id']; ?>" class="btn-icon btn-delete" title="Delete" onclick="return confirm('Delete this booking?');">🗑</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </table>
</div>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>

