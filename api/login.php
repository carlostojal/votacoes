<?php

  if(!$_POST["username"]) {
    echo "USERNAME_NOT_PROVIDED";
    exit();
  }


  if(!$_POST["password"]) {
    echo "PASSWORD_NOT_PROVIDED";
    exit();
  }

  $username = $_POST["username"];
  $password = $_POST["password"];

  require("./connection.php");

  $sql = "SELECT * FROM utilizadores WHERE username = ? AND password = ?";

  $stm = $conn->prepare_statement($sql);
  $stm->bind_param("ss", $username, md5($password));
  $stm->execute();

  $result = $stm->get_result();

  if($result->num_rows == 0) {
    echo "WRONG_CREDENTIALS";
    exit();
  }

  $_SESSION["username"] = $username;

  echo "OK";

  $stm->close();
  $conn->close();
?>