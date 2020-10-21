<?php

  require("./connection.php");

  $sql = "SELECT id, nome, n_votos FROM Lista";
  $result = $conn->query($sql);

  $rows = array();

  while($row = $result->fetch_assoc())
    $rows[] = $row;
  
  echo json_encode($rows);

  $conn->close();
?>