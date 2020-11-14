<?php
  
  try {
    require("./ini_config.php");
    require("./cors.php");

    session_start();
    
    if(!isset($_SESSION["username"])) {
      echo "NOT_AUTHORIZED";
      exit();
    }

    if(!isset($_POST["id"])) {
      echo "LISTA_ID_NOT_PROVIDED";
      exit();
    }

    $lista_id = $_POST["id"];

    require("./connection.php");

    // delete from database
    $sql = "DELETE FROM Lista WHERE id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $lista_id);
    $stm->execute();

    echo "OK";
  } catch(Exception $e) {
    echo "ERROR";
    exit();
  }
?>