<?php
  
  if(!isset($_SESSION['username']))
    header("Location: login.php");
?>
<html>
  <head>
    <?php require("./head.php") ?>
    <title> Votações </title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar_admin.php") ?>
    <div class="jumbotron">
      <h1 class="display-4"> Listas AERBP</h1>
      <p class="lead">Portal de votação.</p>
      <hr class="my-4">
      <p class="lead">
        <a class="btn btn-primary" href="listas.php">Ver listas</a>
      </p>
    </div>
  </body>
</html>
