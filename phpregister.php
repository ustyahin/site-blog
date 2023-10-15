<?php
session_start();
if (isset($_COOKIE['user_login'])) {
    header( 'Location: /feed.php');
}

require ("Database.php");
require ('User.php');

$name = filter_var(trim(htmlspecialchars($_POST['name'])));
$login = filter_var(trim(htmlspecialchars($_POST['login'])));
$password = filter_var(trim(htmlspecialchars($_POST['password'])));
$confirmpassword = filter_var(trim(htmlspecialchars($_POST['confirmpassword'])));

if( mb_strlen($name) > 20 || mb_strlen($login) > 20 || mb_strlen($password) > 20) {
    $_SESSION['error_strlen'] = "Количество симоволов во всех полях не должно превышать 20-ти.";
    header( 'Location:/register.php');
    exit();
}

if(empty($name) || empty($login)|| empty($password) || empty($confirmpassword)) {
    $_SESSION['error_empty'] = "Заполнены не все поля.";
    header( 'Location:/register.php');
    exit();
}

if($password != $confirmpassword) {
    $_SESSION['error_password'] = "Пароли не совпадают.";
    header( 'Location: /register.php');
    exit();
}

$password = sha1($password);

$database = new Database();
$database->connect();
$reg = new User($database);
$reg->register($name, $login, $password);

?>