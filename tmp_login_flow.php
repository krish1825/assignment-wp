<?php
session_start();
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
  'user_id' => 'flowtest_user',
  'password' => 'password123',
  'origin' => 'guest',
];
require __DIR__ . '/login.php';
