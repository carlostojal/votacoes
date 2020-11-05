<?php

  require("./connection.php");
  require("./cors.php");

  $sql = "SELECT id, nome, descricao, imagem FROM Lista";
  $result = $conn->query($sql);

  $rows = array();

  while($row = $result->fetch_assoc())
    $rows[] = $row;
  
  echo json_encode($rows);

  $conn->close();
?>
