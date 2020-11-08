<?php

  try {

    require("./ini_config.php");
    require("./cors.php");

    session_start();

    if(!isset($_SESSION["username"])) {
      echo "NOT_AUTHORIZED";
      exit();
    }

    if(!isset($_POST["name"])) {
      echo "NAME_NOT_PROVIDED";
      exit();
    }

    if(!isset($_POST["description"])) {
      echo "DESCRIPTION_NOT_PROVIDED";
      exit();
    }

    $name = $_POST["name"];
    $description = $_POST["description"];
    $img = NULL;
    if(isset($_FILES["img"])) {
      move_uploaded_file($_FILES["img"]["tmp_name"], "../uploads/".basename($_FILES["img"]["name"]));
      $img = "uploads/".basename($_FILES["img"]["name"]);
    }

    require("./connection.php");

    $sql = "INSERT INTO Lista (nome, descricao, imagem) VALUES (?, ?, ?)";
    $stm = $conn->prepare($sql);
    $stm->bind_param("sss", $name, $description, $img);
    $stm->execute();

    echo "OK";

  } catch(Exception $e) {
    echo "ERROR";
    exit();
  }

?>
