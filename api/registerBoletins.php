<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("../libs/phpmailer/src/Exception.php");
  require("../libs/phpmailer/src/PHPMailer.php");
  require("../libs/phpmailer/src/SMTP.php");

  require("connection.php");

  try {

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPKeepAlive = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "votacoes.aerbp@gmail.com";
    $mail->Password = "@SafePassword123";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("votacoes.aerbp@gmail.com", "Eleicoes AERBP");
    $mail->isHTML(true);
    $mail->Subject = "Boletim de Voto - AERBP";

    $n_processos = 0;
    $atual = 0;

    $ficheiroProcessos = fopen("processos.txt", "r");
    $ficheiroLogs = fopen("mailLogs.txt", "a");

    while(!feof($ficheiroProcessos)) {
      fgets($ficheiroProcessos);
      $n_processos++;
    }

    $n_processos--;

    fclose($ficheiroProcessos);

    $ficheiroProcessos = fopen("processos.txt", "r");

    $startDate = new DateTime("now");

    fwrite($ficheiroLogs, "Comeco: ".$startDate->format("Y-m-d H:i:s")."\n\n");

    for($i = 0; $i < $n_processos; $i++) {
      $processo = fgets($ficheiroProcessos);
      $processo = trim($processo);
      $email = $processo."@ead-aerbp.pt";
      $email = strtolower($email);
      $enc_email = md5($email);
      $cod_confirmacao = rand(1, 1000);
      try {

        // se o boletim ja foi registado avanca para o seguinte
        $sql = "SELECT * FROM Boletim WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $enc_email);
        $stm->execute();

        $result = $stm->get_result();
        if($result->num_rows == 1) {
          fwrite($ficheiroLogs, $email." JA REGISTADO\n");
          continue;
        }

        $sql = "INSERT INTO Boletim (email, cod_confirmacao) VALUES (?, ?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $enc_email, $cod_confirmacao);
        $stm->execute();

        $sql = "SELECT cod FROM Boletim WHERE email = ? AND cod_confirmacao = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $enc_email, $cod_confirmacao);
        $stm->execute();

        $result = $stm->get_result();

        $row = $result->fetch_assoc();
        $cod = $row["cod"];

        $mail->addAddress($email);
        $mail->Body = "Ola.<br><br>Estes sao os dados de que necessitaras para votar.<br><br><ul><li><b>Nº de Boletim:</b> ".$cod."</li><li><b>Codigo de confirmacao:</b> ".$cod_confirmacao."</li></ul><br>Obrigado por votares.";
        $mail->send();
        $mail->clearAddresses();
      } catch(Exception $e) {
        fwrite($ficheiroLogs, "ERRO: ".$mail->ErrorInfo."\n");
      }

      fwrite($ficheiroLogs, $email." registado. ".($i+1)."/".$n_processos." (".((($i+1) / $n_processos) * 100)."%)\n");
    }

    $endDate = new DateTime("now");
    $interval = $startDate->diff($endDate);

    fwrite($ficheiroLogs, "\nFim: ".$endDate->format("Y-m-d H:i:s")." (".$interval->format("%a dias, %h horas, %i minutos e %s segundos").")");

    fclose($ficheiroProcessos);
    fclose($ficheiroLogs);

    $mail->SmtpClose();

  } catch(Exception $e) {
    echo $mail->ErrorInfo;
  }
  
  $stm->close();
  $conn->close();
?>
