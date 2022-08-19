<?php
session_start();

if (isset($_COOKIE['user_login'])) {
}else{
    header( 'Location: /index.php');
}

include("class.php");

$id = $_GET['delpost'];
$del_post = new Database();
$del_post->connect();
$del_post->delete_post();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Сайт блог</title>
        <link rel="stylesheet" href="/blog.css">
    </head>
 
    <body>
    
        <div id="header"><h1 align="center">Блог</h1></div>
        
        <div id="sidebar">
            <p><a href="/sign.php">Войти на сайт</a></p>
            <p><a href="register.php">Зарегистрироваться</a></p>
        </div>

        <div id="content">
            <form>


            </form>
        </div>      
        
        
        
        
    </body>
</html>