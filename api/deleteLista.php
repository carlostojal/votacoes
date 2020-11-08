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

    // get image URL from database
    $sql = "SELECT imagem FROM Lista WHERE id = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $lista_id);
    $stm->execute();

    $result = $stm->get_result();
    if($result->num_rows == 0) {
      echo "LISTA_DOES_NOT_EXIST";
      exit();
    }

    $data = $result->fetch_assoc();

    // delete image
    if($data["imagem"])
      unlink("../".$data["imagem"]);

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