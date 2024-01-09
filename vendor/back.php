<?php
    require_once('connect.php');

    $folder_name = $_POST['name_folder'];
    $folder_path = $_SESSION['folder_path'];

    $querry = mysqli_query($connect, "SELECT `folder_path` FROM `folders` WHERE (`id_folder` = '$folder_path') AND (`folder_path` != 'uploads')");
    
    if (mysqli_num_rows($querry) > 0) {
        $folder_path = mysqli_fetch_assoc($querry);
        $_SESSION['folder_path'] = $folder_path['folder_path'];
    }

