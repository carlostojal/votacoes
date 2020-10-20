<?php

  if(!$_POST["email"]) {
    echo "EMAIL_NOT_PROVIDED";
    exit();
  }

  $id = rand(1, 1000);
  $email = $_POST["email"];

  require("./connection.php");

  $sql = "SELECT id FROM Boletim WHERE email = ?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s", $email);
  $stm->execute();

  $result = $stm->get_result();
  if($result->num_rows > 0) {
    echo "EMAIL_ALREADY_USED";
    exit();
  }

  $sql = "INSERT INTO Boletim (id, email) VALUES (?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("is", $id, $email);
  $stm->execute();

  $stm->close();
  $conn->close();
?>