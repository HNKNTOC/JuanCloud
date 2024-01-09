<?php
    require_once 'connect.php';

    $id_user = $_SESSION['user']['id_user'];
    $folder_name = trim($_POST['folder_name']);
    $folderCheck = mysqli_query($connect, "SELECT * FROM `folders` WHERE `folder_name` = '$folder_name'");

    $folder_path = $_SESSION['folder_path'];

    if (mysqli_num_rows($folderCheck) > 0) {
        $_SESSION['message'] = 'Такое название папки уже существует';
        header('Location: ../lk.php');
    }elseif ($folder_name == '') {
        $_SESSION['message'] = 'Вы не ввели название папки';
        header('Location: ../lk.php');
    }else{
        mysqli_query($connect, "INSERT INTO `folders` (`id_user`, `folder_name`, `folder_path`) VALUES ('$id_user', '$folder_name', '$folder_path')");
    }

    header('Location: ../lk.php');

