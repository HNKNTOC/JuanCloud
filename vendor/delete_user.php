<?php
    require_once('connect.php');

    $id_user = $_POST['id_user'];

    $file_path_query = mysqli_query($connect, "SELECT `file_path` FROM `files` WHERE (`id_user`= '$id_user')");

    while($row = mysqli_fetch_array($file_path_query)){
        unlink('../' . $row['file_path']);
    }

    mysqli_query($connect, "DELETE FROM `users` WHERE `id_user` = '$id_user'");
    
    
    header('Location: ../users_list.php');