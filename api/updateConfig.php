<?php 

  try {

    require("./ini_config.php");
    require("./cors.php");

    session_start();

    if(!isset($_SESSION["username"])) {
      echo "NOT_ALLOWED";
      exit();
    }

    if(!isset($_POST["votes_start"])) {
      echo "VOTES_START_NOT_PROVIDED";
      exit();
    }

    if(!isset($_POST["votes_end"])) {
      echo "VOTES_END_NOT_PROVIDED";
      exit();
    }

    $votes_start = $_POST["votes_start"];
    $votes_end = $_POST["votes_end"];

    $config = new stdClass();
    $config->votes_start = $votes_start;
    $config->votes_end = $votes_end;

    $json = json_encode($config);

    $f = fopen("./config.json", "w");
    fwrite($f, $json);
    fclose($f);

    echo "OK";

  } catch(Exception $e) {
    echo "ERROR";
    exit();
  }
?>