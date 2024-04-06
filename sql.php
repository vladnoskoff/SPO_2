<?php
    header('Content-Type: text/html; charset=utf-8');
    $server = "localhost"; //Ваш сервер MySQL
    $user = "mysor"; //Ваше имя пользователя MySQL
    $pass = "mysor"; //пароль
    $db_name= "mysor";
    
    $db = mysqli_connect($server, $user, $pass, $db_name);	 
    
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
?>