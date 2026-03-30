<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'fullname' => 'Flow Test User',
    'email' => 'flowtest_user@example.com',
    'phoneno' => '9876501234',
    'dob' => '2001-02-03',
    'gender' => 'Male',
    'username' => 'flowtest_user',
    'password' => 'password123',
    'confirm_password' => 'password123',
    'country' => 'India',
    'interests' => ['Drama', 'Action'],
    'bio' => 'Flow test',
];
$_FILES = [];
require __DIR__ . '/guest user/regprocess.php';
