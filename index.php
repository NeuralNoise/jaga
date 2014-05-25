<?php

error_reporting(E_ALL);

require('jaga/config.php');

$user = new User();
$userID = $user->userID;
$username = $user->username;

echo $userID;
echo $username;

?>