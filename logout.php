<?php
session_start();
session_unset();
session_destroy();

header('Location: guest%20user/Sign_in.php');
exit;
