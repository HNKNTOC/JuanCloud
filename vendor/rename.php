<?php
    require_once('connect.php');

    $id_user = $_SESSION['user']['id_user'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $prevName = $_POST['prevName'];

    $folder_path = $_SESSION['folder_path'];

    # проверка на количество строк не работает

    if (!$name == '') {
        if ($type == 'folder') {
            $folderCheck = mysqli_query($connect, "SELECT * FROM `folders` WHERE (`folder_name` = '$name') AND (`id_user` = '$id_user') AND (`folder_path` = '$folder_path')");

            if (mysqli_num_rows($folderCheck) > 0) {
                $_SESSION['message'] = 'Такое название папки уже существует';
            }
            else{
                mysqli_query($connect, "UPDATE `folders` SET `folder_name` = '$name' WHERE (`folder_name` = '$prevName') AND (`folder_path` = '$folder_path')");
            }
        }else{
            $fileCheck = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_folder` = '$folder_path') AND (`file_name` = '$name') AND (`id_user` = '$id_user')");

        if (mysqli_num_rows($fileCheck) > 0) {
            $_SESSION['message'] = 'Такое название файла уже существует';
        }else{
            mysqli_query($connect, "UPDATE `files` SET `file_name` = '$name' WHERE (`file_name` = '$prevName') AND (`id_folder` = '$folder_path')");
        }
        }
    }else{
        $_SESSION['message'] = 'Не введено название';
    }
    
    header('Location: ../lk.php');