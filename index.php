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
        <a href="auth.php">
          Войти
        </a>
      </nav>
    </div>
  </header>


  <main>
    <!-- О нас -->

      <div class="aboutUs">
        <div class="aboutUs__block">
          <div>
            Бесплатное хранилище для ваших файлов
          </div>
          <div>
            Загружайте ваши файлы для быстрого доступа к ним из любой точки мира
          </div>
          <div class="aboutUs__btn">
            <a href="registr.php">
              Зарегистрироваться
            </a>
          </div>
        </div>
        <div class="aboutUs__img"></div>
      </div>

    
  </main>


<!-- Подвал сайта -->

  <footer>
    <div>
      &copy Лузин Никита ИС-18 2022г.
    </div>
  </footer>
</body>
</html>