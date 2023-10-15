<?php

$title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
$text = filter_var(trim($_POST['text']), FILTER_SANITIZE_STRING);
$category = filter_var(trim($_POST['category']), FILTER_SANITIZE_STRING);

require ("Database.php");
require ("Post.php");

$database = new Database();
$database->connect();


$post = new Post($database);
$result = $post->create($title, $text, $category, $_COOKIE['user_id']);

if ($result) {
    header('Location: /feed.php');
} else {
    $_SESSION['error_text'] = "Error: cannot create post." . mysqli_error($database->getLink());
    header('Location: /createpost.php');
}


