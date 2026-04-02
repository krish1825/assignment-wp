<<<<<<< Updated upstream
<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/content_repository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        toggle_record_status('user', $id);
        header('Location: users.php?message=status-updated');
        exit;
    }
}

$users = fetch_users();
$message = $_GET['message'] ?? '';
=======

<?php require_once 'session_check.php'; 

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

>>>>>>> Stashed changes
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo">TicketVerse</div>
    <a href="index1.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php" class="active">Users</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>
        <h3>Users</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
<<<<<<< Updated upstream
        <?php if ($message === 'status-updated'): ?>
            <div class="notice success-notice">User status updated successfully.</div>
        <?php endif; ?>
=======

    
<div class="card" style="padding: 0;">
    <h3 style="padding: 22px 22px 10px 22px;">All Users</h3>
    <table style="border: none; border-radius: 0; box-shadow: none;">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Actions</th></tr>
    <?php if (empty($users)): ?>
    <tr><td colspan="5" style="text-align: center;">No users found.</td></tr>
    <?php else: ?>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><span class="badge badge-<?php echo $user['status'] === 'Active' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($user['status']); ?></span></td>
            <td class="actions-cell">
                <a href="#" class="btn-icon btn-edit" title="Edit">✎</a>
                <a href="users.php?delete_id=<?php echo $user['id']; ?>" class="btn-icon btn-delete" title="Delete" onclick="return confirm('Delete this user?');">🗑</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </table>
</div>
>>>>>>> Stashed changes

        <h3>All Users</h3>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= (int) $user['id'] ?></td>
                        <td><?= e($user['user_id']) ?></td>
                        <td><?= e($user['full_name']) ?></td>
                        <td><?= e($user['email']) ?></td>
                        <td><?= e($user['phone'] ?? '') ?></td>
                        <td><?= e($user['country'] ?? '') ?></td>
                        <td><?= e(ucfirst((string) $user['role'])) ?></td>
                        <td><span class="status-badge <?= e((string) $user['status']) ?>"><?= e(ucfirst((string) $user['status'])) ?></span></td>
                        <td>
                            <form method="post" class="status-form">
                                <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
                                <button type="submit" class="status-btn <?= ($user['status'] ?? 'active') === 'active' ? 'deactivate-btn' : 'activate-btn' ?>" <?= $user['role'] === 'admin' ? 'disabled' : '' ?>>
                                    <?= $user['role'] === 'admin' ? 'Protected' : (($user['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate') ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
