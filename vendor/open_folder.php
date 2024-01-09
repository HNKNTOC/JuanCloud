<?php
    require_once('connect.php');

    $folder_name = $_POST['name_folder'];
    $id_user = $_SESSION['user']['id_user'];

    $folder_path = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_folder` FROM `folders` WHERE `folder_name` = '$folder_name'"));

    $_SESSION['folder_path'] = $folder_path['id_folder'];
