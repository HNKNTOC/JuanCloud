<?php
  require_once('vendor/connect.php');
  $id_user = $_SESSION['user']['id_user'];
  $folder_path = $_SESSION['folder_path'];
  
  $check_admin = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_user'"));
  
    if ($check_admin['id_role'] == '1' || $check_admin['id_role'] == '3') {
        $isAdmin = true;
    }else{
        $isAdmin = false;
    };
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/lk.css">
  <link rel="shortcut icon" href="/img/tab_icon.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <title>Juan Cloud</title>
</head>
<body>
  <header>
    <div class="logo"></div>
    <div class="menu">
      <nav>
        <?php
          if ($isAdmin) {
            echo '<a href="users_list.php" style="margin-right: 20px;">
                    Пользователи
                  </a>';
          }
        ?>
        <a href="vendor/logout.php">
          Выйти
        </a>
      </nav>
    </div>
  </header>


  <main>
    <div class="contForLk">
      <div class="lk">
        <div class="lk__left">
          <div class="lk__btn__upload">
            Загрузить
          </div>
          <div class="lk__menu">
            <div for="files" class="ajax__pnkt__menu <?php if($_SESSION['selectedPnktMenu'] == 'lk1') {echo 'lk__pnkt__menu__active"';}?>" id="lk1">Файлы</div>
            <div for="img" class="ajax__pnkt__menu <?php if($_SESSION['selectedPnktMenu'] == 'lk2') {echo 'lk__pnkt__menu__active"';}?>" id="lk2">Картинки</div>
            <div for="audio" class="ajax__pnkt__menu <?php if($_SESSION['selectedPnktMenu'] == 'lk3') {echo 'lk__pnkt__menu__active"';}?>" id="lk3">Аудио</div>
            <div for="video" class="ajax__pnkt__menu <?php if($_SESSION['selectedPnktMenu'] == 'lk4') {echo 'lk__pnkt__menu__active"';}?>" id="lk4">Видео</div>
          </div>
          <div class="lk__status">
            <div class="progressBar">
              <div style="width: calc(<?php 
                $size_query = mysqli_query($connect, "SELECT `file_size` FROM `files` WHERE `id_user` = '$id_user'"); 
                while($size_array = mysqli_fetch_array($size_query)){
                  $size += (int)$size_array['file_size'];
                };
                $size = round($size /1024, 2);
                echo $size;
                $_SESSION['size_user'] = $size;
              ?> / 500 * 100%);"></div>
            </div>
            <div>
              Свободно <?php echo 500 - $size; ?> из 500 МБ
            </div>
          </div>
        </div>
        
        <div class="lk__right">
          <div class="padding__lk__right">
            <div class="lk__right__head">
              <div>
                <div id="back" <?php 
                  $crnt_folder_path = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `folders` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path')"));
                  $crnt_folder_path = (string)$crnt_folder_path['folder_path'];

                  
                  if ($crnt_folder_path == 'uploads') {
                    echo 'class="btn__disable"';
                  }

                ?>><img src="img/arrow.png" style="width: 25px;height: 25px">Назад</div>
                
              </div>
              <div>
                Файлы
              </div>
            </div>
            <!-- Содержание папки -->
            <div class="lk__right__content">
              <?php
                $id_file = 1;

                $user_folders_query = mysqli_query($connect, "SELECT * FROM `folders` WHERE (`id_user` = '$id_user') AND (`folder_path` = '$folder_path') ORDER BY `folder_name`");

                while($row = mysqli_fetch_array($user_folders_query)){
                  echo '<div class="cock"><div class="lk__right__file" id="file' . $id_file . '">';
                    echo '<div class="folder"></div>';
                    echo '<div id="file' . $id_file . '_text">'; 
                      echo $row['folder_name']; 
                    echo '</div>';
                  echo '</div></div>';

                  $id_file += 1;
                  };

                  switch ($_SESSION['file_type']) {
                    case 'images':
                      $user_files_query = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path') AND (`file_type` = 'image') ORDER BY `file_name`");
                      break;

                    case 'audio':
                      $user_files_query = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path') AND (`file_type` = 'audio') ORDER BY `file_name`");
                      break;

                    case 'video':
                      $user_files_query = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path') AND (`file_type` = 'video') ORDER BY `file_name`");
                      break;
                    
                    default:
                      $user_files_query = mysqli_query($connect, "SELECT * FROM `files` WHERE (`id_user` = '$id_user') AND (`id_folder` = '$folder_path') ORDER BY `file_name`");
                      break;
                  }
                  

                  while($row = mysqli_fetch_array($user_files_query)){
                    echo '<div class="cock"><div class="lk__right__file" id="file' . $id_file . '">';
                      echo '<div class="';
                      switch ($row['file_type']) {
                        case 'image':
                          echo 'img';
                          break;
                        
                        case 'audio':
                          echo 'audio';
                          break;
                        
                        case 'video':
                          echo 'video';
                          break;
                            
                        default:
                          echo 'file_icon';
                          break;
                      }
                      echo '"></div>';
                      echo '<div id="file' . $id_file . '_text">'; 
                        echo $row['file_name']; 
                      echo '</div></div>';
                      echo '<a id="download" class="download__file__btn" download href="';
                        echo $row['file_path'];
                      echo '"><img src="img/download_icon.png" width="15px" height="15px">Скачать</a>';
                    echo '</div>';
  
                    $id_file += 1;
                  };

              ?>
            </div>
          </div>
          <!-- Меню инструментов -->
          <div class="lk__instruments">
              <div id="create__folder">Создать папку</div>
              <div id="delete">Удалить</div>
              <div id="rename">Переименновать</div>
            </div>
        </div>
      </div>
    </div>
  </main>


  <div class="upload__dark upload__window__closed" id="upload__window">
    <form class="upload__window" id="upload__form" method="post" enctype="multipart/form-data" action="vendor/upload_files.php">
      <div class="upload__close" id="close__upload"><div class="upload__close__btn">X</div></div>
      <section class="progress-area"></section>
      <section class="uploaded-area"></section>
      <div>
        <input type="file" name="upload__file" id="upload__file" style="display: none;" class="input__file" required="required">
          <label for="upload__file" id="btn__uploadJS"><span class="input__file-button-text">Выберите файл</span></label>
      </div>
    </form>
  </div>

  <div class="upload__dark upload__window__closed" id="create__folder__window">
    <div class="upload__window">
      <div class="upload__close"><div class="upload__close__btn" id="folderCreate__close__btn">X</div></div>
      <form action="vendor/create_folder.php" method="POST" enctype="multipart/form-data" >
        <input type="text" name="folder_name" placeholder="Название папки">
        <input type="submit" class="upload__window__btn" value="Создать" id="create__folder__btn">
      </form>
    </div>
  </div>

  <div class="upload__dark upload__window__closed" id="rename__window">
    <div class="upload__window">
      <div class="upload__close"><div class="upload__close__btn" id="rename__close__btn">X</div></div>
      <form action="vendor/rename.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="type" style="display: none;" id="file_type">
        <input type="text" name="prevName" style="display: none;" id="prevName">
        <input type="text" name="name" placeholder="Введите название файла" id="name_input">
        <input type="submit" class="upload__window__btn" value="Переименовать" id="create__folder__btn">
      </form>
    </div>
  </div>

  <div class="msg <?php echo isset($_SESSION['message']) ? : 'msg__hide'?>">
    <div>
      <?php echo $_SESSION['message']; unset($_SESSION['message']);?>
    </div>
  </div>
  

  <script src="js/jquery.js"></script>
  <script src="js/script.js"></script>
  <script src="js/ajax.js"></script>
</body>
</html>