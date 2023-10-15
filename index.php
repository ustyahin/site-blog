<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require "Database.php";
require "Post.php";
require "Category.php";

if (isset($_COOKIE['user_login'])) {
    header( 'Location: /feed.php');
}

$database = new Database();
$database->connect();

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
            <p><a href="/register.php">Зарегистрироваться</a></p>
            <p><h3>Категории:</h3></p>
            <p>
                <?php
                $category = new Category($database);
                $categories = $category->getAll();

                foreach ($categories as $cat) {
                    echo "<p><a href='categories.php?cat=".$cat['id']."'>".$cat['name']."</a></p>";
                }
                ?>

        </div>

        <div id="content">
            <?php
            $post = new Post($database);
            $posts = $post->getAll();

            foreach ($posts as $post) {
                echo
                    "<div class='card'>".
                    "<table border='1'>".
                    "<tbody>";
                echo '<h1>' . $post['title'] . '</h1>';
                echo '<p>' . $post['text'] . '</p>';

                    // "<tr><td align='center'>Категория: ".$assoc['category']."</td><td align='center'>Автор: ".$assoc['login']."</td></tr>".
                    // "<tr><td align='center' colspan='2'>".$assoc['title']."</td></tr>".
                    // "<tr><td align='center' colspan='2'>".$assoc['text']."</td></tr>".
                    // "<tr><td align='center'>".$assoc['date']."</td><td>".$assoc['date_changed']."</td></tr>".

                    echo "</tbody>".
                    "</table>".
                    "</div>".
                    "<br />";

            }
            ?>




        </div>      
        
        
        
        
    </body>
</html>
