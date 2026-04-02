<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$stamp = (string) time();
$_POST = [
    'source' => 'guest',
    'fullname' => 'Flow Test',
    'email' => 'flowtest_' . $stamp . '@example.com',
    'phoneno' => '9876543210',
    'dob' => '2000-01-01',
    'gender' => 'Male',
    'username' => 'flow' . $stamp,
    'password' => 'password123',
    'confirm_password' => 'password123',
    'country' => 'India',
    'bio' => 'test user',
];
$_FILES = [];
require __DIR__ . '/register.php';
