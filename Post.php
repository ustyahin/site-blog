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
            `users`.`login`,
            `posts`.`title` AS 'title',
            `posts`.`text` AS 'text',
            `posts`.`date`, 
            `posts`.`date_changed`
        FROM `posts`
        LEFT JOIN `categories` ON `posts`.`category` = `categories`.`id`
        LEFT JOIN `users` ON `posts`.`user` = `users`.`id`
        ORDER BY `id` DESC";

        $query = mysqli_query($this->database->getLink(), $sql);
        $result = [];

        while($row = mysqli_fetch_assoc($query)) {
            $result[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text']
            ];
        }

        return $result;
    }

    public function remove()
    {

    }

    public function update()
    {

    }
}