<?php
require __DIR__ . '/includes/content_repository.php';
$users = fetch_users();
echo count($users) . PHP_EOL;
echo $users[0]['user_id'] . '|' . $users[0]['email'] . '|' . ($users[0]['verification_token_hash'] ?? '');
