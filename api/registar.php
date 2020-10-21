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

      $mail = new PHPMailer();

      $mail->isSMTP();
      $mail->Host = "smtp1.example.com";
      $mail->SMTPAuth = true;
      $mail->Username = "mail@mail.com";
      $mail->Password = "password";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->setAddress($email);
      $mail->Subject = "Boletim de voto";
      $mail->Body = "Boletim de voto nº".$id.".";

      $mail->send();

      echo "RESENT";
      exit();
    }
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
