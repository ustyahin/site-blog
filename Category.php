<?php


class Category
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM `categories`";
        $query = mysqli_query($this->database->getLink(), $sql);

        $result = [];

        while ($row = mysqli_fetch_assoc($query)){
            $result[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];

        }
        return $result;
    }
 }


