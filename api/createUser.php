<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

    session_start();

    if(!isset($_SESSION["username"])) {
      echo "NOT_ALLOWED";
      exit();
    }

    if(!isset($_POST["username"])) {
      echo "USERNAME_NOT_PROVIDED";
      exit();
    }

    if(!isset($_POST["password"])) {
      echo "PASSWORD_NOT_PROVIDED";
      exit();
    }

    $user_username = $_POST["username"];
    $user_password = $_POST["password"];
    $user_password = md5($user_password);

    require("./connection.php");

    $sql = "INSERT INTO Utilizador (username, password) VALUES (?, ?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param("ss", $user_username, $user_password);
    $stm->execute();

    echo "OK";

  } catch(Exception $e) {
    echo "ERROR";
  }
?>