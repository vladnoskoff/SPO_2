<?php
header('Content-Type: text/html; charset=utf-8');
	    include("sql.php"); //соединение с SQL	 

	    session_start(); //начало сессии для записи

        function Fix($str, $pdo) {
            $str = trim($str);
            return $pdo->quote($str);
        }

	    $errmsg = array(); //массив для сохранения ошибок
	     
	    $errflag = false; //флаг ошибки
	 
	 	$email = $_POST['Email'];//имя пользователя
	    $password = $_POST['password'];//пароль

	    //проверка имени пользователя
	    if($email == '') {
	        $errmsg[] = 'Email missing'; //ошибка
	        $errflag = true; //поднимает флаг в случае ошибки
	    }
	 
	    //проверка пароля
	    if($password == '') {
	        $errmsg[] = 'Password missing'; //ошибка
	        $errflag = true; //поднимает флаг в случае ошибки
	    }
	 
	    //если флаг ошибки поднят, направляет обратно к форме регистрации
	    if($errflag) {
	        $_SESSION['ERRMSG'] = $errmsg; //записывает ошибки
	        session_write_close(); //закрытие сессии
	        header("location: index.html"); //перенаправление
	        exit();
	    }
	 
	    //запрос к базе данных
	    $qry = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '" . md5($password) . "'";
	    $result = mysqli_query($db,$qry);
	     
	    //проверка, был ли запрос успешным (есть ли данные по нему)
	    if(mysqli_num_rows($result) == 1) {
	        while($row = mysqli_fetch_assoc($result)) {
	            $_SESSION['Email'] = $email;//устанавливает, совпадает ли имя пользователя с сессионным 
	            session_write_close(); //закрытие сессии
	            require ("main.html");
	        	exit();
	        }
	    } else {
	        $_SESSION['ERRMSG'] = "Invalid Email or Password"; //ошибка
	        session_write_close(); //закрытие сессии
	        header("location: index.html"); //перенаправление
	        exit(); 
	    }
	?>