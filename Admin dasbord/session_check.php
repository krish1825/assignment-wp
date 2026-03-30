<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: Sign_in.php");
    exit;
}
require_once 'db.php';
?>
