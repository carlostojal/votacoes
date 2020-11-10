<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

    session_start();

    if(!isset($_SESSION["username"])) {
      echo "NOT_ALLOWED";
      exit();
    }

    if(!isset($_POST["email"])) {
      echo "EMAIL_NOT_PROVIDED";
      exit();
    }

    $email = $_POST["email"];

    require("./connection.php");

    $sql = "SELECT cod, cod_confirmacao, usado FROM Boletim WHERE email = ?";
    $email = trim(strtolower($email));
    $email = md5($email);
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $email);
    $stm->execute();

    $result = $stm->get_result();
    if($result->num_rows == 0) {
      echo "EMAIL_DOES_NOT_EXIST";
      exit();
    }

    $data = $result->fetch_assoc();

    echo json_encode($data);
  } catch(Exception $e) {
    echo "ERROR";
  }
?>
