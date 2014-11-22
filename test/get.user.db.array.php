<?php
require_once(dirname(__FILE__).'/../config.php');

$UserService = new User_Service('ofanebob','780170',0);
$user_credentials = $UserService->get_user_database_read();

$check_user_exist = $UserService->check_user_exist();

var_dump($check_user_exist);

print_r($user_credentials);
?>
<br />
<?= $user_credentials['user_id'] ?>