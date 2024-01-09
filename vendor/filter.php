<?php
    require_once('connect.php');

    $crntActivePnktMenu = $_POST['crntActivePnktMenu'];

    switch ($crntActivePnktMenu) {
        case '2':
            $_SESSION['file_type'] = 'images';
            $_SESSION['selectedPnktMenu'] = 'lk2';
            break;
        
        case '3':
            $_SESSION['file_type'] = 'audio';
            $_SESSION['selectedPnktMenu'] = 'lk3';
            break;

        case '4':
            $_SESSION['file_type'] = 'video';
            $_SESSION['selectedPnktMenu'] = 'lk4';
            break;
    
        default:
            $_SESSION['file_type'] = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path') ORDER BY `file_name`");
            $_SESSION['selectedPnktMenu'] = 'lk1';
            break;
    }