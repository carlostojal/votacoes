<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

    require("./getConfig.php");

    $config = getConfig();

    session_start();

    if(!isset($_SESSION["username"])) {

      if($config->stats_public == "true") {
        $date = new DateTime();

        if($date->getTimestamp() < $config->votes_end) {
          echo "TOO_EARLY";
          exit();
        }
      } else {
        echo "NOT_ALLOWED";
        exit();
      }
    }


    require("./connection.php");

    $sql = "SELECT Lista.id, Lista.nome, COUNT(*) AS n_votos FROM Voto LEFT JOIN Lista ON Voto.lista = Lista.id GROUP BY Voto.lista ORDER BY n_votos DESC";
    $result = $conn->query($sql);

    $rows = array();

    while($row = $result->fetch_assoc())
      $rows[] = $row;
    
    echo json_encode($rows);

    $conn->close();

  } catch(Exception $e) {
    echo "ERROR";
    exit();
  }
?>
