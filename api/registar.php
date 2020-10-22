<?php

  if(!$_POST["email"]) {
    echo "EMAIL_NOT_PROVIDED";
    exit();
  }

  $max_votes_per_ip = 3;
  $should_limit_ip = true;

  $id = rand(1, 10000);
  $email = $_POST["email"];
  $ip = $_SERVER["REMOTE_ADDR"];

  require("./connection.php");
  require("./sendCode.php");

  // check if already exists
  $sql = "SELECT id, usado FROM Boletim WHERE email = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s", $email);
  $stm->execute();

  $result = $stm->get_result();
  if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row["usado"]) {
      echo "ALREADY_VOTED";
      exit();
    } else {
      sendCode($row["id"], $email);
      echo "RESENT";
      exit();
    }
  }

  // check if IP address voted the max allowed times
  if($should_limit_ip) {
    $sql = "SELECT id FROM Boletim WHERE endereco_ip = ?";
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
  $sql = "INSERT INTO Boletim (id, email, endereco_ip) VALUES (?, ?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("iss", $id, $email, $ip);
  $stm->execute();

  sendCode($id, $email);
  echo "OK";

  $stm->close();
  $conn->close();
?>
