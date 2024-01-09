<?php

require_once 'connect.php';

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    $logcheck = mysqli_query($connect,"SELECT `login` FROM `users` WHERE `login` = '$login'");
    $emailcheck = mysqli_query($connect,"SELECT `email` FROM `users` WHERE `email` = '$email'");

    if (($login == '') or ($email == '') or ($password == '') or ($password_confirm == '')) {
        $_SESSION['message'] = 'Не все поля заполнены';
        header('Location: ../registr.php');
    }else{
        if (mysqli_num_rows($logcheck) > 0) {
            $_SESSION['message'] = 'Такой логин уже занят';
            header('Location: ../registr.php');
        }else{
            if (mysqli_num_rows($emailcheck) > 0) {
                $_SESSION['message'] = 'Эта почта уже занята';
                header('Location: ../registr.php');
            }else{
                if ($password_confirm === $password){
                
                    $password = md5($password);
            
                    mysqli_query($connect, "INSERT INTO `users` (`login`, `email`, `password`) VALUES ('$login', '$email', '$password')");
            
                    $_SESSION['message'] = 'Регистрация прошла успешно!';
                    header('Location: ../registr.php');
                } else {
                    $_SESSION['message'] = 'Пароли не совпадают';
                    header('Location: ../registr.php');
                }
            }
        }
    }   


    // Создание папки для пользователя
    $id_user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_user` FROM `users` WHERE `login` = '$login'"));
    $id_user = (int)$id_user['id_user'];

    mysqli_query($connect, "INSERT INTO `folders` (`id_user`, `folder_name`, `folder_path`) VALUES ('$id_user', 'root_folder', 'uploads')");
?>
