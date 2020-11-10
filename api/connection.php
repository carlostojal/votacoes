<?php 

  require("./constants.php");

  $servername = VOTACOES_DB_HOST;
  $database = VOTACOES_DB_NAME;
  $username = VOTACOES_DB_USERNAME;
  $password = VOTACOES_DB_PASSWORD;

  $conn = new mysqli($servername, $username, $password, $database);

?>