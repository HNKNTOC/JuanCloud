<?php
    require_once('connect.php');


    $id_user = $_SESSION['user']['id_user'];

    $fileName = explode(".", $_FILES['upload__file']['name']);

    $fileType = $_FILES['upload__file']['type'];
    $folder_path = $_SESSION['folder_path'];
    $size = round($_FILES['upload__file']['size'] / 1024 , 2);

    $user_files_size = $_SESSION['size_user'];

    if (!(round($size /1024, 2) + $user_files_size > 500)) {
        $file_path = 'uploads/' . time() . $fileName[0] . 'UsEr' . $id_user . '.' . $fileName[1];


        $fileCheck = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as HowMuch FROM `files` WHERE (`id_folder` = '$folder_path') AND (`file_name` LIKE '$fileName[0]%') AND (`id_user` = '$id_user')"));

        if (!$fileCheck['HowMuch'] == 0) {
            $fileName[0] = $fileName[0] . ' (' . $fileCheck['HowMuch'] . ')';  
        }
        if (move_uploaded_file($_FILES['upload__file']['tmp_name'], '../' . $file_path)) {
            $fileType = explode("/", $fileType);

            mysqli_query($connect, "INSERT INTO `files` (`id_user`, `file_name`, `file_path`, `id_folder`, `file_size`, `file_type`) VALUES ('$id_user', '$fileName[0]', '$file_path', '$folder_path', '$size', '$fileType[0]')");
        }else{
            $_SESSION['message'] = 'Ошибка при загрузке файла';
            header('Location: ../lk.php');
        }
    }else{
        header('Location: ../lk.php');
        $_SESSION['message'] = 'Не хватает места на диске';
    }

    
        


    

    header('Location: ../lk.php');
