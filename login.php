<?php
session_start();

require_once __DIR__ . '/includes/content_repository.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: guest%20user/Sign_in.php');
    exit;
}

$userId = trim($_POST['user_id'] ?? '');
$password = (string) ($_POST['password'] ?? '');
$origin = trim($_POST['origin'] ?? '');

$fallback = 'guest%20user/Sign_in.php';
if ($origin === 'admin') {
    $fallback = 'Admin%20dasbord/Sign_in.php';
} elseif ($origin === 'normal') {
    $fallback = 'Normal%20user/Sign_in.php';
}

$user = find_user_for_login($userId);

if (!$user || (string) $user['password'] !== $password) {
    header('Location: ' . $fallback . '?error=Invalid%20userID%20or%20password');
    exit;
}

if (($user['status'] ?? 'active') !== 'active') {
    header('Location: ' . $fallback . '?error=Your%20account%20is%20inactive');
    exit;
}

if (!is_user_email_verified($user)) {
    header('Location: ' . $fallback . '?error=' . rawurlencode('Please verify your email before signing in.') . '&user=' . rawurlencode($userId));
    exit;
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {
    header('Location: Admin%20dasbord/index1.php');
    exit;
}

header('Location: Normal%20user/home.php');
exit;
