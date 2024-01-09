<?php
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

    if (mysqli_num_rows($check_user) > 0){

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id_user" => $user['id_user'],
            "login" => $user['login'],
            "folder" => $user['folder'],
            "role" => $user['id_role']
        ];

        $id_user = $user['id_user'];

        $folder_path_id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_folder` FROM `folders` WHERE (`id_user` = '$id_user') AND (`folder_path` = 'uploads')"));
        $_SESSION['folder_path'] = $folder_path_id['id_folder'];
        
        $_SESSION['file_type'] = 'all';
        $_SESSION['selectedPnktMenu'] = 'lk1';

        header('Location: ../lk.php');

    }else{
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../auth.php');
    }
