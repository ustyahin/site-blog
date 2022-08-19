<?php
session_start();
if (isset($_COOKIE['user_login'])) {
    header( 'Location: /feed.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Сайт блог</title>
        <link rel="stylesheet" href="/blog.css">
    </head>
 
    <body>
        <div id="header"><h1 align="center">Войти на сайт</h1></div>
    
        <div id="sidebar">
            <p>Нет аккаунта?</p>
            <p><a href="/register.php">Зарегестрируйтся</a></p>
            <p><a href="/index.php">Назад на главную</a></p>
        </div>
        

        <div id="content">
            <form action="phpsign.php" method="POST">
                <label>Логин</label>
                <p><input required type="text" name="login"></p>
                <label>Пароль</label>
                <p><input required type="password" name="password"></p>
                <p><input type="submit" value="Войти"></p>  
            </form>

            <p>
                <?php 
                echo $_SESSION['error_strlen'];
                unset ($_SESSION['error_strlen']);
                echo $_SESSION['error_empty'];
                unset ($_SESSION['error_empty']);
                echo $_SESSION['error_password'];
                unset ($_SESSION['error_password']);
                echo $_SESSION['error_login'];
                unset ($_SESSION['error_login']);
                echo $_SESSION['error_sign'];
                unset ($_SESSION['error_sign']);
                ?>
            </p>
        </div>
    </body>
</html>