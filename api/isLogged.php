<?php

  require("./cors.php");

  session_start();

  echo isset($_SESSION["username"]) ? "TRUE" : "FALSE";
?>