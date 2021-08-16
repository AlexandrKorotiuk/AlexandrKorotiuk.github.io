<?php
  $hostname = "localhost";
  $dbname = "test";
  $dbUser = "root";
  $dbPassword = "";
  $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $dbUser, $dbPassword);
  $commentText = $_POST["commentText"];
  $commentFirstname = $_POST["commentFirstname"];
  $commentLastname = $_POST["commentLastname"];
  $commentRating = intval($_POST['commentRating']);
  $commentEmail = $_POST["commentEmail"];
  $commentCreated = date('d.m.Y H:i:s');
  $errors=[];
  if (!filter_var($commentEmail, FILTER_VALIDATE_EMAIL) ) {
    $errors["errorEmail"] =  "Недопустимый емайл";
    }
    if (mb_strlen($commentLastname) < 3 || empty($commentLastname)) {
        $errors["errorLastname"] = "Недопустимая фамилия";
    }
    if (mb_strlen($commentFirstname) < 3 || empty($commentFirstname) ) {
        $errors["errorFirstname"] = "Недопустимое имя";
    }
    if (empty($commentRating)) {
        $errors["errorRating"] = "Оцените товар!"; 
    }
    if (mb_strlen($commentText) > 1000) {
        $errors["errorMessage"] = "Недопустимое количество символов";
    }
    if(empty($errors)) {
        $bdComent = $dbh->prepare(
            "INSERT INTO comments (message,firstname,lastname,rating,email)  VALUES (:commentText,:commentFirstname,:commentLastname,:commentRating,:commentEmail)"
        );
        $bdComent->bindParam(":commentText", $commentText);
        $bdComent->bindParam(":commentFirstname", $commentFirstname);
        $bdComent->bindParam(":commentLastname", $commentLastname);
        $bdComent->bindParam(":commentRating", $commentRating);
        $bdComent->bindParam(":commentEmail", $commentEmail);
        $bdComent->execute();
        $commentResult = [$commentFirstname,$commentLastname,$commentText,$commentRating,$commentEmail,$commentCreated];
        echo json_encode($commentResult);
    } else  {
        $_SESSION["errors"] = $errors;
    }
