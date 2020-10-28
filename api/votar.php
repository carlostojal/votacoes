<?php

  if(!isset($_POST["boletim"])) {
    echo "CODE_NOT_PROVIDED";
    exit();
  }

  if(!isset($_POST["codigo_confirmacao"])) {
    echo "CONFIRMATION_CODE_NOT_PROVIDED";
    exit();
  }

  if(!isset($_POST["lista"])) {
    echo "LISTA_NOT_PROVIDED";
    exit();
  }

  $codigo = $_POST["boletim"];
  $codigo_confirmacao = $_POST["codigo_confirmacao"];
  $lista = $_POST["lista"];

  require("./connection.php");

  $sql = "SELECT * FROM Boletim WHERE cod = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("i", $codigo);
  $stm->execute();

  $result = $stm->get_result();

  if($result->num_rows == 0) {
    echo "NOT_REGISTERED";
    exit();
  } else {

    $row = $result->fetch_assoc();

    if($row["cod_confirmacao"] != $codigo_confirmacao) {
      echo "WRONG_CONFIRMATION_CODE";
      exit();
    } else if($row["usado"]) {
      echo "ALREADY_VOTED";
      exit();
    } else {

      $sql = "UPDATE Boletim SET usado = '1' WHERE cod = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("i", $row["cod"]);
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