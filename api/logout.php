<?php

  require("./ini_config.php");
  require("./cors.php");

  try { 
    session_start();

    session_destroy();

    echo "OK";
  } catch(Exception $e) {
    echo "ERROR";
  }
?>