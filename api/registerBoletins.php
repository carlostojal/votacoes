<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require("./libs/phpmailer/src/Exception.php");
  require("./libs/phpmailer/src/PHPMailer.php");
  require("./libs/phpmailer/src/SMTP.php");

  require("./connection.php");
  require("./constants.php");

  try {

    $mail = new PHPMailer(true);

    $mail->SMTPDebug = true;
    $mail->isSMTP();
    $mail->SMTPKeepAlive = true;
    $mail->Host = VOTACOES_EMAIL_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = VOTACOES_EMAIL;
    $mail->Password = VOTACOES_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(VOTACOES_EMAIL);
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

    // $n_processos--;

    fclose($ficheiroProcessos);

    $ficheiroProcessos = fopen("processos.txt", "r");

    $startDate = new DateTime("now");

    fwrite($ficheiroLogs, "Comeco: ".$startDate->format("Y-m-d H:i:s")."\n\n");

    for($i = 0; $i < $n_processos; $i++) {
      $email = fgets($ficheiroProcessos);
      $email = trim($email);
      $email = strtolower($email);
      $enc_email = md5($email);
      $cod_confirmacao = rand(1, 1000);
      $exists = false;
      try {

        // se o boletim ja foi registado avanca para o seguinte
        $sql = "SELECT cod, enviado FROM Boletim WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $enc_email);
        $stm->execute();

        $result = $stm->get_result();
        if($result->num_rows == 1) {
          $data = $result->fetch_assoc();
          if($data["enviado"]) {
            fwrite($ficheiroLogs, $email." JA REGISTADO\n");
            continue;
          }
          $exists = true;
        }

        if(!$exists) {
          // create
          $sql = "INSERT INTO Boletim (email, cod_confirmacao) VALUES (?, ?)";
          $stm = $conn->prepare($sql);
          $stm->bind_param("si", $enc_email, $cod_confirmacao);
          $stm->execute();
        }

        // get code
        $sql = "SELECT cod FROM Boletim WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $enc_email);
        $stm->execute();

        $result = $stm->get_result();

        $row = $result->fetch_assoc();
        $cod = $row["cod"];

        // send email
        $mail->addAddress($email);
        $mail->Body = "Bom dia,<br>
        A comissão eleitoral vem por este meio disponibilizar os 
        boletins de voto e respetivos códigos de acesso para eleger
        a Associação de Estudantes da Escola Secundária Rafael Bordalo
        Pinheiro no ano letivo de 2020/2021.<br>
        1º Abrir o link abaixo indicado<br>
        2º Colocar o código de acesso descrito no email<br>
        3º Proceder à votação e submeter o questionário<br>
        <b>É possível votar em branco!<br>
        Basta submeter o questionário sem assinalar qualquer opção.</b><br><br>
        <ul>
        <li><b>Link:</b> <a href='".VOTACOES_FRONTEND."/#/votar'>".VOTACOES_FRONTEND."/#/votar</a></li>
        <li><b>Nº de Boletim:</b> ".$cod."</li>
        <li><b>Código de confirmação:</b> ".$cod_confirmacao."</li>
        </ul>";
        $mail->send();
        $mail->clearAddresses();

        // set email as sent
        $sql = "UPDATE Boletim SET enviado = '1' WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $enc_email);
        $stm->execute();

        fwrite($ficheiroLogs, $email." registado. ".($i+1)."/".$n_processos." (".((($i+1) / $n_processos) * 100)."%)\n");
      } catch(Exception $e) {
        fwrite($ficheiroLogs, "ERRO: ".$mail->ErrorInfo."\n");
      }
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
  
  $conn->close();
?>
