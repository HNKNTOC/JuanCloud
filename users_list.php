<?php
  require_once('vendor/connect.php');
  $id_user = $_SESSION['user']['id_user'];
  $folder_path = $_SESSION['folder_path'];
  
  $check_admin = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_user'"));
  
    if (!($check_admin['id_role'] == '1' || $check_admin['id_role'] == '3')) {
        header('Location: lk.php');
      }


?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/lk.css">
  <link rel="shortcut icon" href="/img/tab_icon.png" type="image/png">
  <title>Juan Cloud</title>
</head>
<body>
  <header>
    <div class="logo"></div>
    <div class="menu">
      <nav>
        <a href="lk.php" style="margin-right: 20px;">
          Личный кабинет
        </a>
        <a href="vendor/logout.php">
          Выйти
        </a>
      </nav>
    </div>
  </header>


  <main>
    <section class="cont">
      <div class="user__row user__row__head">
        <div class="id__user">user id</div>
        <div class="user__login">Логин</div>
        <div class="user__email">E-mail</div>
        <?php
          if ($_SESSION['user']['role'] == 1) {
            echo '<form class="user__role">Изменить роль</form>';
          }
        ?>
        <form class="user__delete">Удалить пользователя</form>
      </div>

      <?php
        if ($_SESSION['user']['role'] == 1) {
          $users_query = mysqli_query($connect, "SELECT * FROM `users` WHERE (`id_user` != '$id_user') ORDER BY `id_user`");
        }else{
          $users_query = mysqli_query($connect, "SELECT * FROM `users` WHERE (`id_user` != '$id_user') AND (`id_role` != 1) AND (`id_role` != 3) ORDER BY `id_user`");
        }

        while($row = mysqli_fetch_array($users_query)){
        echo '<div class="user__row flex">';
        echo  '<div class="id__user">' . $row['id_user'] . '</div>';
        echo  '<div class="user__login">' . $row['login'] . '</div>';
        echo  '<div class="user__email">' . $row['email'] . '</div>';
        
        if ($_SESSION['user']['role'] == 1) {
          echo  '<form action="vendor/change_role.php" method="POST" enctype="multipart/form-data">';
            echo  '<input type="text" name="id_user" style="display: none;" value="' . $row['id_user'] . '">';
            echo  '<select name="id_role">';
              echo '<option value="1" '; if ($row['id_role'] == '1') {echo 'selected';} echo '>Админ</option>';
              echo '<option value="2" '; if ($row['id_role'] == '2') {echo 'selected';} echo '>Пользователь</option>';
              echo '<option value="3" '; if ($row['id_role'] == '3') {echo 'selected';} echo '>Модератор</option>';
            echo  '</select>';
            echo  '<input type="submit" value="Изменить">';
          echo  '</form>';
        }
        
        echo  '<form action="vendor/delete_user.php" method="POST" enctype="multipart/form-data"">';
          echo  '<input type="text" name="id_user" style="display: none;" value="' . $row['id_user'] . '">';
        echo    '<input type="submit" value="Удалить">';
        echo  '</form>';
        echo '</div>';
        };
      ?>
      
    </section>
  </main>


  

  <!-- <div class="msg">
    <?php 
      echo $_SESSION['message']; 
      unset($_SESSION['message']);
    ?>
  </div> -->

  <script src="js/jquery.js"></script>
  <script src="js/script.js"></script>
  <script src="js/ajax.js"></script>
</body>
</html>