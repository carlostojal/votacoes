<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

    session_start();

    if(!isset($_SESSION["username"])) {
      echo "NOT_ALLOWED";
      exit();
    }

    require("./connection.php");
    $sql = "SELECT COUNT(*) n_votos, HOUR(Voto.data_hora) as hora FROM Voto GROUP BY HOUR(Voto.data_hora)";
    $result = $conn->query($sql);

    $rows = array();

    while($row = $result->fetch_assoc())
      $rows[] = $row;
    
    echo json_encode($rows);

    $conn->close();

  } catch(Exception $e) {
    echo "ERROR";
  }
?>