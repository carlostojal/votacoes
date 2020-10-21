<?php

  if(!$_POST["email"]) {
    echo "EMAIL_NOT_PROVIDED";
    exit();
  }

  $id = rand(1, 1000);
  $email = $_POST["email"];

  require("./connection.php");

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
      sendCode($row["id"]);
      echo "RESENT";
      exit();
    }
  }

  $sql = "INSERT INTO Boletim (id, email) VALUES (?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("is", $id, $email);
  $stm->execute();

  sendCode($id);
  echo "OK";

  $stm->close();
  $conn->close();
?>
