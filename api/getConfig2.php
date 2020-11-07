<?php
  
  require("./cors.php");
  require("./getConfig.php");

  echo json_encode(getConfig());

?>