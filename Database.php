<?php

class Database
{
   private $link;

   public function connect()
   {
        $this->link = mysqli_connect("localhost", "egor", "some_password");
        mysqli_select_db($this->link, "site-blog");

        if ($this->link == false) {
            throw new Exception('Нет подключения к БД');
        }
   }
   
  
   public function register($name, $login, $password)
   {
        $name = mysqli_real_escape_string($this->link, $name);   
        $login = mysqli_real_escape_string($this->link, $login);
        $password = mysqli_real_escape_string($this->link, $password);

        //Проверка на свободный логин при регистрации
        $sql_check_user = "SELECT COUNT(*) AS 'value' FROM `users` WHERE `login` = '$login'";
        $query_check_user = mysqli_query($this->link, $sql_check_user);
        $assoc_chek_user = mysqli_fetch_assoc($query_check_user);
        if($assoc_chek_user['value'] > 0) {
            $_SESSION['error_login'] = "Пользователь с таким логином уже существует.";
            header( 'Location: /register.php');
            exit();
        }

        $sql = "INSERT INTO `users` (`name`, `login`, `password`, `admin`) VALUES ('$name', '$login', '$password', '0')";
        $query = mysqli_query($this->link, $sql);
        if($query == false) {
            echo mysqli_error($this->link);
        }
       header('Location: sign.php');
   }

   public function sign($login, $password)
   {
        $login = mysqli_real_escape_string($this->link, $login);
        $password = mysqli_real_escape_string($this->link, $password);
        $password = sha1($password);

        $sql = "SELECT `id`, `name`, `login` FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
        $query = mysqli_query($this->link, $sql);
        if(mysqli_num_rows($query) == 1) {
            $user = mysqli_fetch_assoc($query);
            setcookie("user_id", $user['id'], time() + 604800);
            setcookie("user_name", $user['name'], time() + 604800);
            setcookie("user_login", $user['login'], time() + 604800);
            header( 'Location: /feed.php');
        } else {
            $_SESSION['error_sign'] = "Пользователь не найден";
            header( 'Location:/sign.php');
            }
   }

    public function getLink(): mysqli
    {
        return $this->link;
    }

    public function getCategories()
    {
        $result = [];

        $sql = "SELECT `id`, `name` FROM `posts`";
        $query = mysqli_query($this->link, $sql);

        while ($assoc = mysqli_fetch_assoc($query)) {
            $result[] = [
                'id' => $assoc['id'],
                'name' => $assoc['name']
            ];
        }

        return $result;
    }

    public function delete_post()
    {
        $id = filter_var(trim($_GET['delpost']), FILTER_SANITIZE_NUMBER_INT);
        $id = mysqli_real_escape_string($this->link, $id);
        
        if (empty($id)) {
            $_SESSION['error_empty'] = "Ошибка запроса. id не числовое значение!";
            header( 'Location: /feed.php');
            exit();
        }
        
        if (mb_strlen($id) > 5) {
            $_SESSION['error_strlen'] = "Ошибка запроса. Некоректный id продукта!";
            header( 'Location: /feed.php'); 
            exit();
        }

        $valid_sql = "SELECT `id` FROM `posts`";
        $valid_query = mysqli_query($this->link, $valid_sql);
        $array_query = mysqli_fetch_array($valid_query);
        if (in_array($id, $array_query, true)) {
        }else {
            $_SESSION['error_post'] = "Такого поста не существует!";
            header( 'Location: /feed.php');
        }

        $sql = "DELETE FROM `posts` WHERE `id` = '$id'";
        $query = mysqli_query($this->link, $sql);
        if ($query == true) {
            header(' Location: /feed.php');
        }else{
            $_SESSION['error_post'] = "Ошибка запроса удаления поста!";
            header(' Location: /feed.php');
        }
        
    }
    
    public function delete_po($id)
    {
        $sql = "DELETE FROM `posts` WHERE `id` = $id";
        $query = mysqli_query($this->link, $sql);


    }



}

?>
