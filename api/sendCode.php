<?php

  require("../libs/phpmailer/src/Exception.php");
  require("../libs/phpmailer/src/PHPMailer.php");
  require("../libs/phpmailer/src/SMTP.php");

  function sendCode($id) {
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
  }
?>
