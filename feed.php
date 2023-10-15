<?php
session_start();
if (isset($_COOKIE['user_login'])) {
}else{
    header( 'Location: /index.php');
}

require ("Database.php");
$database = new Database();
$database->connect();

require ("Post.php");
require ("Category.php");

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
            <p><?php echo $_COOKIE['user_name'] ?></p>
            <p><a href="/feed.php">На главную</a></p>
            <p><a href="/createpost.php">Создать публикацию</a></p>
            <p><a href="logout.php">Выйти</a></p>
            <p><h3>Категории:</h3></p>
            <p>
                <?php
                $category = new Category($database);
                $categories = $category->getAll();

                foreach ($categories as $cat) {
                    echo "<p><a href='categories.php?cat=".$cat['id']."'>".$cat['name']."</a></p>";
                }
                ?>
            </p>
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
                echo "<h1><a href='select.php?select=".$post['id']."'>".$post['title']."</a></h1>";
                echo '<p>' . $post['text'] . '</p>';

                echo "<tr><td align='center'>Категория: ".$post['category']."</td><td align='center'>Автор: ".$post['user']."</td></tr>";
                echo "<tr><td align='center'>Дата: ".$post['date']."</td><td align='center'>Изменено: ".$post['date_changed']."</td></tr>";

                if ($_COOKIE['admin'] == "1" || $post['user'] == $_COOKIE['user_login'])
                {
                    echo "<tr><td align='center'><a href='deletepost.php?del=".$post['id']."'>Удалить</a></td>";
                    echo "<td align='center'><a href='changepost.php?change=".$post['id']."'>Изменить</a></td></tr>";

                }

                //"</td><td align='center'>Дата изменения: ".$post['date_changed']."</td></tr>";
                // "<tr><td align='center' colspan='2'>".$assoc['title']."</td></tr>".
                // "<tr><td align='center' colspan='2'>".$assoc['text']."</td></tr>".
                // "<tr><td align='center'>".$assoc['date']."</td><td>".$assoc['date_changed']."</td></tr>".

                echo "</tbody>".
                    "</table>".
                    "</div>".
                    "<br />";

            }
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

        
        
        
    </body>
</html>