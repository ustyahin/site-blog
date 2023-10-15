<?php

class Database
{
    private const DB_HOST = 'localhost';
    private const DB_USERNAME = 'egor';
    // TODO const for database_password, database_name

   private $link;

   public function connect()
   {
        $this->link = mysqli_connect(self::DB_HOST, self::DB_USERNAME, 'some_password');
        mysqli_select_db($this->link, 'site-blog');

        if ($this->link == false) {
            throw new Exception('Нет подключения к БД');
        }
   }


    public function getLink(): mysqli
    {
        return $this->link;
    }







}

?>
