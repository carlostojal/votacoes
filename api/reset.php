<?php

  $sql = "DELETE FROM Boletim WHERE email = 'carlos.tojal@hotmail.com'";

  require("connection.php");

  $conn->query($sql);

  echo "OK";
?>
