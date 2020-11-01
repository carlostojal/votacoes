<?php

  if(!$_POST["process_number"]) {
    echo "PROCESS_NUMBER_NOT_PROVIDED";
    exit();
  }

  $max_votes_per_ip = 3;
  $should_limit_ip = false;

  $cod = rand(1, 10000);
  $cod_confirmacao = rand(1, 10000);
  $process_number = $_POST["process_number"];
  $ip = $_SERVER["REMOTE_ADDR"];

  $email = $process_number."@ead-aerbp.pt";
  $email = strtolower($email);
  $enc_email = md5($email);

  require("./connection.php");
  require("./sendCode.php");

  // check if already exists
  $sql = "SELECT cod, cod_confirmacao, usado FROM Boletim WHERE email = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s", $enc_email);
  $stm->execute();

  $result = $stm->get_result();
  if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row["usado"]) {
      echo "ALREADY_VOTED";
      exit();
    } else {
      sendCode($row["cod"], $row["cod_confirmacao"], $email);
      echo "RESENT";
      exit();
    }
  }

  // check if IP address voted the max allowed times
  if($should_limit_ip) {
    $sql = "SELECT cod FROM Boletim WHERE endereco_ip = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $ip);
    $stm->execute();

    $result = $stm->get_result();
    if($result->num_rows >= $max_votes_per_ip) {
      echo "REGISTER_BLOCKED";
      exit();
    }
  }

  // register
  $sql = "INSERT INTO Boletim (cod_confirmacao, email, endereco_ip) VALUES (?, ?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("iss", $cod_confirmacao, $enc_email, $ip);
  $stm->execute();

  // get code
  $sql = "SELECT cod FROM Boletim WHERE email = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s", $enc_email);
  $stm->execute();

  $result = $stm->get_result();
  $row = $result->fetch_assoc();
  $cod = $row["cod"];

  sendCode($cod, $cod_confirmacao, $email);
  echo "OK";

  $stm->close();
  $conn->close();
?>
