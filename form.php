<?php
    header('Content-Type: text/html; charset=utf-8');
    // Подключение к базе данных
    include("sql.php"); //соединение с SQL
    
    session_start(); //начало сессии для записи

    function Fix($str, $pdo) {
        $str = trim($str);
        return $pdo->quote($str);
    }

    $errmsg = array(); //массив для сохранения ошибок
     
    $errflag = false; //флаг ошибки
    
    // Получение данных из формы
    $full_name = $_POST['FullName'];
    $phone_number = $_POST['Number'];
    $date = $_POST['Date'];
    $garbage_type = $_POST['Type'];
    $volume = $_POST['Volume'];
    $address = $_POST['Address'];
    $postal_code = $_POST['Postcode'];
    $confirm_address = $_POST['ConfirmAddress'];
    
    // Вставка данных в базу данных
    $sql = "INSERT INTO forma (FullName, Number, Date, Type, Volume, Address, Postcode)
    VALUES ('$full_name', '$phone_number', '$date', '$garbage_type', '$volume', '$address', '$postal_code')";
    if ($address != $confirm_address) {
        echo "Введенные адреса не совпадают. Пожалуйста, введите адрес еще раз.";
    } else {
        if ($db->query($sql) === TRUE) {
            echo "Запись успешно добавлена";
            header("Location: main.html");
        } else {
            header("Location: form.html");
            echo "Ошибка: " . $sql . "<br>" . $db->error;
        }
    }
    
    $db->close();
?>