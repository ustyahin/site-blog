<?php
session_start();

if (isset($_COOKIE['user_login'])) {
}else{
    header( 'Location: /index.php');
}

require ("Database.php");
require ("Post.php");

$database = new Database();
$database->connect();

$id = filter_var(trim($_GET['del']), FILTER_SANITIZE_STRING);

$del_post = new Post($database);
$result = $del_post->remove($id);

if ($result) {
    header('Location: /feed.php');
} else {
    $_SESSION['error_text'] = "Error: cannot delete post." . mysqli_error($database->getLink());
    header('Location: /changepost.php');
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