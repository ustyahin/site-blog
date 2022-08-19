<?php
session_start();

session_unset();

setcookie("user_name", null, -1);

setcookie("user_id", null, -1);

setcookie("user_login", null, -1);

header( 'Location: /index.php');

?>