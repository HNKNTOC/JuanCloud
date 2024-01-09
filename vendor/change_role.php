<?php
    require_once('connect.php');

    $id_user = $_POST['id_user'];
    $id_role = $_POST['id_role'];
    
    mysqli_query($connect, "UPDATE `users` SET `id_role` = '$id_role' WHERE `id_user` = '$id_user'");
    
    header('Location: ../users_list.php');