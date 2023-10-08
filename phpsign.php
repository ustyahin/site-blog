<?php
session_start();
if (isset($_COOKIE['user_login'])) {
    header( 'Location: /feed.php');
}

include("Database.php");

$login = filter_var(trim(htmlspecialchars($_POST['login'])));
$password = filter_var(trim(htmlspecialchars($_POST['password'])));

if(mb_strlen($login) > 20 || mb_strlen($password) > 20) {
    $_SESSION['error_strlen'] = "Количество симоволов во всех полях не должно превышать 20-ти.";
    header( 'Location:/sign.php');
    exit();
}

if(empty($login) || empty($password)) {
    $_SESSION['error_empty'] = "Заполнены не все поля.";
    header( 'Location: /sign.php');
    exit();
}

$sign = new Database();
$sign->connect();
$result = $sign->sign($login, $password);
if (!empty($result)) {
    $time = time() + 604800;
    setcookie("user_id", $result['id'], $time);
    setcookie("user_name", $result['name'], $time);
    setcookie("user_login", $result['login'], $time);
    header( 'Location: /feed.php');
} else {
    header( 'Location: /sign.php');
}

?>