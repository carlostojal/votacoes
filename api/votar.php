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

  require("./getConfig.php");

  $config = getConfig();

  $date = new DateTime();

  if($date->getTimestamp() * 1000 < $config->votes_start) {
    echo "TOO_EARLY";
    exit();
  }

  if($date->getTimestamp() * 1000 > $config->votes_end) {
    echo "TOO_LATE";
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

      $sql = "SELECT id FROM Lista WHERE id = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("i", $lista);
      $stm->execute();

      $res = $stm->get_result();
      if($res->num_rows == 0 && $lista != "null") {
        echo "INVALID_LIST";
        exit();
      }

      $sql = "UPDATE Boletim SET usado = '1' WHERE cod = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("i", $row["cod"]);
      $stm->execute();

      $sql = "UPDATE Lista SET n_votos = n_votos + 1 WHERE id = ?";
      $stm = $conn->prepare($sql);
      $stm->bind_param("i", $lista);
      $stm->execute();

      echo "OK";
    }
  }

  $conn->close();
?>
