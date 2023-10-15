<?php

class User
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function register($name, $login, $password)
    {
        $name = mysqli_real_escape_string($this->database->getLink(), $name);
        $login = mysqli_real_escape_string($this->database->getLink(), $login);
        $password = mysqli_real_escape_string($this->database->getLink(), $password);

        //Проверка на свободный логин при регистрации
        $sql_check_user = "SELECT COUNT(*) AS 'value' FROM `users` WHERE `login` = '$login'";
        $query_check_user = mysqli_query($this->database->getLink(), $sql_check_user);
        $assoc_chek_user = mysqli_fetch_assoc($query_check_user);
        if($assoc_chek_user['value'] > 0) {
            $_SESSION['error_login'] = "Пользователь с таким логином уже существует.";
            header( 'Location: /register.php');
            exit();
        }

        $sql = "INSERT INTO `users` (`name`, `login`, `password`, `admin`) VALUES ('$name', '$login', '$password', '0')";
        $query = mysqli_query($this->database->getLink(), $sql);
        if($query == false) {
            echo mysqli_error($this->database->getLink());
        }
        header('Location: sign.php');
    }


    public function sign($login, $password): array
    {
        $login = mysqli_real_escape_string($this->database->getLink(), $login);
        $password = mysqli_real_escape_string($this->database->getLink(), $password);
        $password = sha1($password);

        $result = [];

        $sql = "SELECT `id`, `name`, `login`, `admin` FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
        $query = mysqli_query($this->database->getLink(), $sql);

        if (mysqli_num_rows($query) == 1) {
            $user = mysqli_fetch_assoc($query);
            $result['name'] = $user['name'];
            $result['id'] = $user['id'];
            $result['login'] = $user['login'];
            $result['admin'] = $user['admin'];
        }

        return $result;
    }
















}