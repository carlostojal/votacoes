<?php

  session_start();

  if(!isset($_SESSION["username"])) {
    echo "NOT_ALLOWED";
    exit();
  }

  require("./connection.php");

  $sql = "SELECT id, nome, n_votos FROM Lista";
  $result = $conn->query($sql);

  $rows = array();

  while($row = $result->fetch_assoc())
    $rows[] = $row;

  // get empty votes
  $sql = "SELECT COUNT(Boletim.cod) - SUM(Lista.n_votos) AS votos_brancos FROM Boletim JOIN Lista WHERE Boletim.usado = '1'";
  
  echo json_encode($rows);

  $conn->close();
?>