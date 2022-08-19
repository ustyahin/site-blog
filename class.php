<?php

session_start();

use Database as GlobalDatabase;

class Database
{
   public $link;
   public function connect()
   {
        $this->link = mysqli_connect("localhost", "root", "");
        mysqli_select_db($this->link, "blog");

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

   public function show_all_posts()
   {
        $sql = "SELECT `posts`.`id` AS 'post_id', `categories`.`category`, `users`.`login`, `posts`.`title`, `posts`.`text`, `posts`.`date`, `posts`.`date_changed`
        FROM `posts`
        INNER JOIN `categories` ON `posts`.`category` = `categories`.`id`
        INNER JOIN `users` ON `posts`.`user` = `users`.`id`";
        
        
        $query = mysqli_query($this->link, $sql);

        while($assoc = mysqli_fetch_assoc($query)) {
            echo 
            "<div class='card'>".
            "<table border='1'>".
                    "<tbody>".
                        "<tr><td align='center'>Категория: ".$assoc['category']."</td><td align='center'>Автор: ".$assoc['login']."</td></tr>". 
                        "<tr><td align='center' colspan='2'>".$assoc['title']."</td></tr>". 
                        "<tr><td align='center' colspan='2'>".$assoc['text']."</td></tr>". 
                        "<tr><td align='center'>".$assoc['date']."</td><td>".$assoc['date_changed']."</td></tr>".
                    "</tbody>".
                "</table>".
            "</div>".
            "<br />";
            
            if ($assoc['login'] == $_COOKIE['user_login']) {
                echo "<a href='deletepost.php?editpost=".$assoc['post_id']."'>Редактировать пост</a>";
                echo "<br />";
                echo "<a href='deletepost.php?delpost=".$assoc['post_id']."'>Удалить пост</a>";
            }
        }
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
