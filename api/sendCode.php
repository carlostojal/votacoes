<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("../libs/phpmailer/src/Exception.php");
  require("../libs/phpmailer/src/PHPMailer.php");
  require("../libs/phpmailer/src/SMTP.php");

  function sendCode($cod, $cod_confirmacao, $email) {

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
      $mail->Body = "Ola.<br><br>Estes sao os dados de que necessitaras para votar.<br><br><ul><li><b>Nº de Boletim:</b> ".$cod."</li><li><b>Codigo de confirmacao:</b> ".$cod_confirmacao."</li></ul><br>Obrigado por votares.";

      $mail->send();

    } catch(Exception $e) {
      echo $mail->ErrorInfo;
    } 
  }
?>
