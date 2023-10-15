<?php

class Post
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        $sql = "SELECT
            `posts`.`id` AS 'id',
            `categories`.`name` as 'category_name',
            `users`.`login`as 'user',
            `posts`.`title` AS 'title',
            `posts`.`text` AS 'text',
            `posts`.`date`, 
            `posts`.`date_changed`
        FROM `posts`
        LEFT JOIN `categories` ON `posts`.`category`= `categories`.`id`
        LEFT JOIN `users` ON `posts`.`user` = `users`.`id`
        ORDER BY `id` DESC";

        $query = mysqli_query($this->database->getLink(), $sql);
        $result = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date'],
                'date_changed' => $row['date_changed'],
                'category' => $row['category_name'],
                'user' => $row['user']
            ];
        }

        return $result;
    }

    public function create($title, $text, $category, $user): bool
    {
        $sql = "INSERT INTO 
                `posts` 
                (`title`, `text`, `date`, `date_changed`, `user`, `category`) 
                VALUES 
                ('$title', '$text', NOW(), NOW(), '$user', '$category')";

        $query = mysqli_query($this->database->getLink(), $sql);
        echo mysqli_error($this->database->getLink());
        return $query;
    }

    public function category($cat)
    {
        $sql = "SELECT
            `posts`.`id` AS 'id',
            `categories`.`name` as 'category_name',
            `users`.`login`as 'user',
            `posts`.`title` AS 'title',
            `posts`.`text` AS 'text',
            `posts`.`date`, 
            `posts`.`date_changed`
        FROM `posts` 
        LEFT JOIN `categories` ON `posts`.`category`= `categories`.`id`    
        LEFT JOIN `users` ON `posts`.`user` = `users`.`id`
        WHERE `posts`.`category` = '$cat'
        ORDER BY `id` DESC";

        $query = mysqli_query($this->database->getLink(), $sql);
        $result = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date'],
                'date_changed' => $row['date_changed'],
                'category' => $row['category_name'],
                'user' => $row['user']
            ];
        }

        return $result;

    }

    public function remove($id)
    {
        $sql = "DELETE FROM `posts` WHERE `id` = '$id'";
        $query = mysqli_query($this->database->getLink(), $sql);
        return $query;
    }

    public function update($title, $text, $category, $id)
    {
        $sql = "UPDATE `posts` 
                SET `title` = '$title', 
                `text` = '$text', 
                `category` = '$category', 
                `date_changed` = NOW() 
                WHERE `id` = '$id'";

        $query = mysqli_query($this->database->getLink(), $sql);
        echo mysqli_error($this->database->getLink());
        return $query;
    }

    public function select($select)
    {
        $sql_post = "SELECT
            `posts`.`id` AS 'id',
            `categories`.`name` AS 'category_name',
            `users`.`login` AS 'user',
            `posts`.`title` AS 'title',
            `posts`.`text` AS 'text',
            `posts`.`date`, 
            `posts`.`date_changed`
        FROM `posts` 
        LEFT JOIN `categories` ON `posts`.`category`= `categories`.`id`    
        LEFT JOIN `users` ON `posts`.`user` = `users`.`id`
        WHERE `posts`.`id` = '$select'
        ORDER BY `id` DESC";

        $query = mysqli_query($this->database->getLink(), $sql_post);
        $result = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date'],
                'date_changed' => $row['date_changed'],
                'category' => $row['category_name'],
                'user' => $row['user']
            ];
        }

        return $result;
    }


}