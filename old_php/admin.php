<?php
  
  session_start();
  
  if(!isset($_SESSION['username']))
    header("Location: login.php");
?>
<html>
  <head>
    <?php require("./head.php") ?>
    <title>Area Administrativa</title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar_admin.php") ?>
    <div class="jumbotron">
      <h1 class="display-4">Area administrativa</h1>
    </div>
  </body>
</html>
