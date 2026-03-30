<?php require_once 'session_check.php'; 

if (isset($_GET['delete_type']) && isset($_GET['id'])) {
    $type = $_GET['delete_type'];
    $id = (int)$_GET['id'];
    
    if ($type === 'event') {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($type === 'movie') {
        $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: events.php");
    exit;
}

// Fetch events
$stmt = $conn->query("SELECT id, event_name as name, category, event_date as date, 'event' as type FROM events ORDER BY event_date DESC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch movies
$stmt = $conn->query("SELECT id, title as name, genre as category, release_date as date, 'movie' as type FROM movies ORDER BY release_date DESC");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$all_items = array_merge($events, $movies);
usort($all_items, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

?>
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
    <a href="Sign_in.php?logout=true">Logout</a>
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
    <h3 style="padding: 22px 22px 10px 22px;">All Events & Movies</h3>
    <table style="border: none; border-radius: 0; box-shadow: none;">
    <tr><th>ID</th><th>Name</th><th>Category/Genre</th><th>Date</th><th>Type</th><th>Actions</th></tr>
    <?php if (empty($all_items)): ?>
    <tr><td colspan="6" style="text-align: center;">No events or movies found.</td></tr>
    <?php else: ?>
        <?php foreach ($all_items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['id']); ?></td>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo htmlspecialchars($item['category']); ?></td>
            <td><?php echo htmlspecialchars(date('d M Y', strtotime($item['date']))); ?></td>
            <td><span class="badge badge-<?php echo $item['type'] === 'movie' ? 'success' : 'warning'; ?>"><?php echo ucfirst($item['type']); ?></span></td>
            <td class="actions-cell">
                <a href="#" class="btn-icon btn-edit" title="Edit">✎</a>
                <a href="events.php?delete_type=<?php echo $item['type']; ?>&id=<?php echo $item['id']; ?>" class="btn-icon btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');">🗑</a>
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

