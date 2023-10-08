<?php

class Category
{
    public function getAll()
    {
        $sql = "SELECT `name` FROM 'categories'";
        $query = mysqli_query($this->database->getLink(), $sql);
        $result = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = ['category' => $row['name']];
        }
    }
 }