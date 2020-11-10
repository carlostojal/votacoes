<?php

  try {
    if(!isset($_POST["process"])) {
      echo "PROCESS_NUMBER_NOT_PROVIDED";
      exit();
    }

    $process = $_POST["process"];

    require("./connection.php");

    $sql = "SELECT cod, cod_confirmacao FROM Boletim WHERE email = ?";
    $email = trim(strtolower($process))."@ead-aerbp.pt";
    $email = md5($email);
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $email);
    $stm->execute();

    $result = $stm->get_result();
    if($result->num_rows == 0) {
      echo "PROCESS_NUMBER_DOES_NOT_EXIST";
      exit();
    }

    $data = $result->fetch_assoc();

    echo json_encode($data);
  } catch(Exception $e) {
    echo "ERROR";
  }
?>
