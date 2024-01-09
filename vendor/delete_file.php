<?php
    require_once('connect.php');

    $id_user = $_SESSION['user']['id_user'];
    $folder_path = $_SESSION['folder_path'];
    $fileName = $_POST['file_name'];

    $file_path = mysqli_fetch_array(mysqli_query($connect, "SELECT `file_path` FROM `files` WHERE (`id_user`= '$id_user') AND (`file_name` = '$fileName') AND (`id_folder` = '$folder_path')"));
    $file_path = (string)$file_path['file_path'];

    if(unlink('../' . $file_path)){
        mysqli_query($connect, "DELETE FROM `files` WHERE (`id_user`= '$id_user') AND (`file_name` = '$fileName') AND (`id_folder` = '$folder_path')");
    };

    

    