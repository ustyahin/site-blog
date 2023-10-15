<?php
session_start();
if (isset($_COOKIE['user_login'])) {
}else{
    header( 'Location: /index.php');
}

require ("Database.php");
$database = new Database();
$database->connect();

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

<div id="header"><h1 align="center">Создать публикацию</h1></div>

<div id="sidebar">
    <p><?php echo $_COOKIE['user_name'] ?></p>
    <p><a href="/feed.php">На главную</a></p>
    <p><a href="logout.php">Выйти</a></p>
    <p><h3>Категории:</h3></p>
    <p>
        <?php
        $category = new Category($database);
        $categories = $category->getAll();

        foreach ($categories as $category) {
            echo '<p>' . $category['name'] . '</p>';
        }
        ?>
    </p>
</div>

<?php

if ($_SESSION['error_text']) {
    echo '<p>' . $_SESSION['error_text'] . '</p>';
}

?>

<div id="content">
    <form action="phpcreatepost.php" method="POST">
        <label>Заголовок поста:</label>
        <p><input type="text" name="title"></p>
        <label>Текст поста:</label>
        <p><input type="text" name="text"></p>
        <label>Категория поста:</label>
        <p><select id="category" name="category"></p>

        <?php
        $getcategory = new Category($database);
        $getcategories = $getcategory->getAll();

        foreach ($getcategories as $cat)
            {
                echo "<option value =".$cat['id'].">".$cat['name']."</option>";
            }

            echo "</select>";
        ?>
        <p><input type="submit" value="Создать"></p>
    </form>
</div>