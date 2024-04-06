<?php
header('Content-Type: text/html; charset=utf-8');
	    //reg.php
	    include("sql.php"); //соединение с SQL
	 
	    session_start(); //начало сессии для записи
	 
	    function Fix($str, $pdo) {
            $str = trim($str);
            return $pdo->quote($str);
        }
	 
	    $errmsg = array(); //массив для хранения ошибок 
	     
	    $errflag = false; //флаг ошибки
	  
	    $name      = $_POST['Name'];      //имя 
	    $email     = $_POST['Email'];          //Email
	    $password  = $_POST['password'];  //пароль
	 
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
	 
	    //проверка, свободно ли имя пользователя
	    if($email != '') {
	        $qry = "SELECT * FROM `users` WHERE `email` = '$email'"; //запрос к MySQL
			$result = mysqli_query($db, $qry);
	        
	        if($result) {
	            if(mysqli_num_rows($result) > 0) {//если имя уже используется
	                $errmsg[] = 'Такой логин уже используется'; //сообщение об ошибке
	                $errflag = true; //поднимает флаг в случае ошибки
	            }
	            mysqli_free_result($result);
	        }
	    }
	 
	    //если данные не прошли валидацию, направляет обратно к форме регистрации
	    if($errflag) {
	        $_SESSION['ERRMSG'] = $errmsg; //сообщение об ошибке
	        session_write_close(); //закрытие сессии
	        header("location: index.html");//перенаправление
	        exit();
	    }

	    //добавление данных в базу
	    $qry = "INSERT INTO `mysor`.`users`(`Name` , `email`, `password`) VALUES('$name','$email','" . md5($password) . "')";
	    $result = mysqli_query($db, $qry);
	    //проверка, был ли успешным запрос на добавление
	    if($result) {
	    	
	        header("location: index.html");
	        exit();
	    } else {
	        die("Ошибка, обратитесь позже");
	    }
	?>