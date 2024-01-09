<?php
    session_start();

    $connect = mysqli_connect('localhost', 'root', '', 'JuanCloud');

    if (!$connect){
        die('Error connect to DataBase');
    }