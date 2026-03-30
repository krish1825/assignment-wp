<?php
require 'includes/content_repository.php';
$user = find_user_for_login('flowtest_user');
echo $user ? ($user['user_id'] . '|' . $user['email'] . '|' . $user['status']) : 'not-found';
