<?php

  function getConfig() {

    $file = fopen("./config.json", "r");

    $contents = fread($file, filesize("./config.json"));
    fclose($file);

    $config = json_decode($contents);
    return $config;

  }
?>
