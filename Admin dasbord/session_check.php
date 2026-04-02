<?php
session_start();
<<<<<<< Updated upstream
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
=======
if (!isset($_SESSION['admin_id']) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
>>>>>>> Stashed changes
    header("Location: Sign_in.php");
    exit;
}
?>
