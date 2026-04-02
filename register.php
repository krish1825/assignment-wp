<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content_repository.php';

$source = trim((string) ($_POST['source'] ?? 'guest'));
$signupPath = $source === 'normal' ? 'Normal%20user/sign_up.php' : 'guest%20user/sign_up.php';
$signinPath = $source === 'normal' ? 'Normal%20user/Sign_in.php' : 'guest%20user/Sign_in.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $signupPath);
    exit;
}

$fullName = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phoneno'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = (string) ($_POST['password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');
$country = trim($_POST['country'] ?? '');
$interests = isset($_POST['interests']) && is_array($_POST['interests']) ? implode(', ', $_POST['interests']) : '';
$bio = trim($_POST['bio'] ?? '');

function registration_redirect(string $signupPath, array $data, string $message): never
{
    $query = http_build_query([
        'error' => $message,
        'fullname' => $data['fullname'] ?? '',
        'email' => $data['email'] ?? '',
        'phoneno' => $data['phoneno'] ?? '',
        'dob' => $data['dob'] ?? '',
        'gender' => $data['gender'] ?? '',
        'username' => $data['username'] ?? '',
        'country' => $data['country'] ?? '',
        'bio' => $data['bio'] ?? '',
    ]);
    header('Location: ' . $signupPath . '?' . $query);
    exit;
}

$formData = [
    'fullname' => $fullName,
    'email' => $email,
    'phoneno' => $phone,
    'dob' => $dob,
    'gender' => $gender,
    'username' => $username,
    'country' => $country,
    'bio' => $bio,
];

$errors = [];
if ($fullName === '') {
    $errors[] = 'Full name is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Enter a valid email address.';
}
if ($phone !== '' && !preg_match('/^[0-9]{10}$/', $phone)) {
    $errors[] = 'Phone number must be exactly 10 digits.';
}
if ($gender === '') {
    $errors[] = 'Please select gender.';
}
if ($username === '' || strlen($username) < 5) {
    $errors[] = 'Username must be at least 5 characters.';
}
if ($password === '' || strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters.';
}
if ($password !== $confirmPassword) {
    $errors[] = 'Password and confirm password must match.';
}
if (user_exists($username, $email)) {
    $errors[] = 'Username or email already exists.';
}

if ($errors !== []) {
    registration_redirect($signupPath, $formData, implode(' ', $errors));
}

try {
    $photoPath = store_uploaded_image($_FILES['photo'] ?? [], 'user');

    $newUserId = create_registered_user([
        'user_id' => $username,
        'full_name' => $fullName,
        'email' => $email,
        'password' => $password,
        'phone' => $phone,
        'dob' => $dob,
        'gender' => $gender,
        'country' => $country,
        'interests' => $interests,
        'bio' => $bio,
        'photo_path' => $photoPath,
    ]);

    $user = find_user_by_numeric_id($newUserId);
    if ($user === null) {
        throw new RuntimeException('User record could not be loaded after registration.');
    }

    send_verification_for_user($user);
} catch (Throwable $exception) {
    registration_redirect($signupPath, $formData, 'Registration failed. ' . $exception->getMessage());
}

$successMessage = 'Registration completed. Please verify your email before signing in. A verification link was saved to storage/mail/verification.log for local testing.';
header('Location: ' . $signinPath . '?success=' . rawurlencode($successMessage) . '&user=' . rawurlencode($username));
exit;
