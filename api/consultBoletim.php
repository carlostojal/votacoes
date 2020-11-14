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

    $stm->store_result();

    $stm->bind_result($cod, $cod_confirmacao, $usado);

    if($stm->num_rows == 0) {
      echo "EMAIL_DOES_NOT_EXIST";
      exit();
    }

    while($stm->fetch()) {
      $object = new stdClass();
      $object->cod = $cod;
      $object->cod_confirmacao = $cod_confirmacao;
      $object->usado = $usado;
    }

    echo json_encode($object);
  } catch(Exception $e) {
    echo "ERROR";
  }
?>
