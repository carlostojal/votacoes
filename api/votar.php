<?php

  if(!isset($_POST["email"])) {
    echo "EMAIL_NOT_PROVIDED";
    exit();
  }

  if(!isset($_POST["codigo"])) {
    echo "CODE_NOT_PROVIDED";
    exit();
  }

  if(!isset($_POST["lista"])) {
    echo "LISTA_NOT_PROVIDED";
    exit();
  }

  $email = $_POST["email"];
  $codigo = $_POST["codigo"];
  $lista = $_POST["lista"];

  require("./connection.php");

  $sql = "SELECT * FROM Boletim WHERE email = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s", $email);
  $stm->execute();

  $result = $stm->get_result();

  if($result->num_rows == 0) {
    echo "EMAIL_NOT_REGISTERED";
    exit();
  } else {

    $row = $result->fetch_assoc();

    // invalid ID
    if($row["id"] != $codigo) {
      echo "INVALID_CODE";
      exit();
    } else if($row["usado"]) {
      echo "ALREADY_VOTED";
      exit();
    } else {

      $sql = "UPDATE Boletim SET usado = '1' WHERE id = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("i", $row["id"]);
      $stm->execute();

      $sql = "UPDATE Lista SET n_votos = n_votos + 1 WHERE nome = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("s", $lista);
      $stm->execute();

      echo "OK";
    }
  }

  $conn->close();
?>