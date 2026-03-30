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
    <a href="users.php">Users</a>
    <a href="profile.php">Profile</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Users</h3>
        <a class="profile-btn" href="profile.php">Admin Profile</a>
    </div>

    <div class="page-content">
        <?php if ($message === 'status-updated'): ?>
            <div class="notice success-notice">User status updated successfully.</div>
        <?php endif; ?>

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
