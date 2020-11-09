<?php

  require("./cors.php");
  require("./ini_config.php");

  if(!$_POST["username"]) {
    echo "USERNAME_NOT_PROVIDED";
    exit();
  }


  if(!$_POST["password"]) {
    echo "PASSWORD_NOT_PROVIDED";
    exit();
  }

  $user = $_POST["username"];
  $pass = $_POST["password"];
  $pass = md5($pass);

  require("./connection.php");

  $sql = "SELECT * FROM Utilizador WHERE username = ? AND password = ?";

  $stm = $conn->prepare($sql);
  $stm->bind_param("ss", $user, $pass);
  $stm->execute();

  $result = $stm->get_result();

  if($result->num_rows == 0) {
    echo "WRONG_CREDENTIALS";
    exit();
  }

  session_start();

  $_SESSION["username"] = $user;

  echo "OK";

  $stm->close();
  $conn->close();
?>