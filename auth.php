<?php
  session_start();
  require_once('vendor/retutn_lk.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="/img/tab_icon.png" type="image/png">
  <title>Juan Cloud</title>
</head>
<body>
  <header>
    <a href="index.php">
      <div class="logo"></div>
    </a>
    <div class="menu">
      <nav>
        <a href="registr.php">
          Зарегестрироваться
        </a>
      </nav>
    </div>
  </header>


  <main>
    <!-- Форма авторизации -->

    <form action="vendor/signin.php" method="post" class="registr">
      <div class="registr__title">
        Авторизация
      </div>
      <input name="login" type="text" placeholder="Логин">
      <input name="password" type="password" placeholder="Пароль">
      <div class="registr__btn">
        <input type="submit" value="Войти">
      </div>
      <p>
        <?php
          if (isset($_SESSION['message'])){
            echo $_SESSION['message'];
          }
          unset($_SESSION['message']);
        ?>
      </p>
    </form>

  </main>


 <!-- Подвал сайта -->

 <footer>
  <div>
    &copy Лузин Никита ИС-18 2022г.
  </div>
</footer>
</body>
</html>