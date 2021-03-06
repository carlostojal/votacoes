<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

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
    if($lista == "null" || $lista == "undefined")
      $lista = NULL;

    // echo $lista;

    require("./connection.php");

    $sql = "SELECT cod, cod_confirmacao, usado FROM Boletim WHERE cod = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $codigo);
    $stm->execute();

    $stm->store_result();

    $stm->bind_result($cod, $cod_confirmacao, $usado);

    if($stm->num_rows == 0) {
      echo "NOT_REGISTERED";
      exit();
    } else {

      while($stm->fetch()) {
        if($cod_confirmacao != $codigo_confirmacao) {
          echo "WRONG_CONFIRMATION_CODE";
          exit();
        } else if($usado) {
          echo "ALREADY_VOTED";
          exit();
        } else {

          $sql = "SELECT id FROM Lista WHERE id = ?";
          $stm = $conn->prepare($sql);
          $stm->bind_param("i", $lista);
          $stm->execute();

          $stm->store_result();

          if($stm->num_rows == 0 && $lista != NULL) {
            echo "INVALID_LIST";
            exit();
          }

          $sql = "UPDATE Boletim SET usado = '1' WHERE cod = ?";
          $stm = $conn->prepare($sql);
          $stm->bind_param("i", $codigo);
          $stm->execute();

          $sql = "INSERT INTO Voto (lista) VALUES (?)";
          $stm = $conn->prepare($sql);
          $stm->bind_param("i", $lista);
          $stm->execute();

          echo "OK";
        }
      }
    }

    $conn->close();

  } catch(Exception $e) {
    echo "ERROR";
  }
?>
