<?php
    require_once('connect.php');

    $folder_name = $_POST['folder_name'];
    $id_user = $_SESSION['user']['id_user'];

    $id_folder = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_folder` FROM `folders` WHERE (`id_user` = '$id_user') AND (`folder_name` = '$folder_name')"));
    $id_folder = (string)$id_folder['id_folder'];

    $file_path_query = mysqli_query($connect, "SELECT `file_path` FROM `files` WHERE (`id_user`= '$id_user') AND (`id_folder` = '$id_folder')");
    $file_path = mysqli_fetch_array($file_path_query);
    $file_path = (string)$file_path['file_path'];

    if (mysqli_num_rows($file_path_query)> 0) {
        if(unlink('../' . $file_path)){
            mysqli_query($connect, "DELETE FROM `files` WHERE (`id_user`= '$id_user') AND (`id_folder` = '$id_folder')");
            mysqli_query($connect, "DELETE FROM `folders` WHERE (`id_user`= '$id_user') AND (`id_folder` = '$id_folder')");
        }
    }else{
        mysqli_query($connect, "DELETE FROM `folders` WHERE (`id_user`= '$id_user') AND (`id_folder` = '$id_folder')");
    };

    