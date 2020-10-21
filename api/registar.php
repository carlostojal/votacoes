<?php

  require("../libs/phpmailer/src/Exception.php");
  require("../libs/phpmailer/src/PHPMailer.php");
  require("../libs/phpmailer/src/SMTP.php");

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
      
    }
    // se foi usado, retorna erro e sai
    // senão, reenvia código do boletim
  }

  $sql = "INSERT INTO Boletim (id, email) VALUES (?, ?)";
  $stm = $conn->prepare($sql);
  $stm->bind_param("is", $id, $email);
  $stm->execute();

  // envia código do boletim

  echo "OK";

  $stm->close();
  $conn->close();
?>