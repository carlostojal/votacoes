<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("../libs/phpmailer/src/Exception.php");
  require("../libs/phpmailer/src/PHPMailer.php");
  require("../libs/phpmailer/src/SMTP.php");

  function sendCode($id, $email) {

    try {

      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "votacoes.aerbp@gmail.com";
      $mail->Password = "@SafePassword123";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->setFrom("votacoes.aerbp@gmail.com");
      $mail->isHTML(true);
      $mail->addAddress($email);
      $mail->Subject = "Boletim de Voto - AERBP";
      $mail->Body = "Ola.<br><br>Foi-te atribuido o boletim de voto no. <b>".$id."</b>.<br><br>Obrigado por votares.";

      $mail->send();

    } catch(Exception $e) {
      echo $mail->ErrorInfo;
    } 
  }
?>
