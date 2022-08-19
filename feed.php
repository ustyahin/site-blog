<?php
session_start();
include("class.php");
if (isset($_COOKIE['user_login'])) {
}else{
    header( 'Location: /index.php');
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
            <p><a href="/feed.php">На главную</a></p>
            <p><a href="logout.php">Выйти</a></p>
            <p><h3>Категории:</h3></p>
        </div>

        <div id="content">
            <?php
            $show_all_posts = new Database();
            $show_all_posts->connect();
            $show_all_posts->show_all_posts();
            ?>
            
            <p>
                <?php 
                echo $_SESSION['error_strlen'];
                unset ($_SESSION['error_strlen']);
                echo $_SESSION['error_empty'];
                unset ($_SESSION['error_empty']);
                echo $_SESSION['error_post'];
                unset ($_SESSION['error_post']);
                ?>
            </p>
        </div>      
        faffsf
        
        
        
    </body>
</html>