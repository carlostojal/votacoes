<?php

  if(!$_POST["email"]) {
    echo "EMAIL_NOT_PROVIDED";
    exit();
  }

  $id = rand(1, 10000);
  $email = $_POST["email"];

  require("./connection.php");
  require("./sendCode.php");

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

  $ip = $_SERVER["REMOTE_ADDR"];

  $sql = "INSERT INTO Boletim (id, email, endereco_ip) VALUES (?, ?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("iss", $id, $email, $ip);
  $stm->execute();

  sendCode($id, $email);
  echo "OK";

  $stm->close();
  $conn->close();
?>
