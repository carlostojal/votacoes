<?php

  session_start();

  if(!isset($_SESSION["username"])) {
    echo "NOT_AUTHORIZED";
    exit();
  }

?>
<html>
  <head>
    <?php require("./head.php") ?>
    <title>Consultar Boletim</title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar_admin.php") ?>
    <div class="jumbotron">
      <h1 class="display-4">Consultar Boletim</h1>
    </div>
    <div class="container">
      <div class="form-group">
        <label for="process">Nº de Processo</label>
        <input type="text" class="form-control" id="process" placeholder="aXXXX">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" id="consult">
          <div class="spinner-border" role="status" id="spinner_consult">
            <span class="sr-only">Carregando...</span>
          </div>
          <span id="consult_text">Consultar</span>
        </button>
    </div>
  </body>
  <script>
        
    $("#spinner_consult").hide();

    $("#process").val(localStorage.getItem("consult_process"));

    $("#process").on("input", () => {
       localStorage.setItem("consult_process", $("#process").val());
    });

    $("#consult").click(() => {

      $("#consult_text").hide();
      $("#spinner_consult").show();

      $.post("./api/consultBoletim.php", {process: localStorage.getItem("consult_process")}, (data) => {

        $("#consult_text").show();
        $("#spinner_consult").hide();

        let out = null;
        try {
          out = JSON.parse(data);

          alertify.alert("Boletim", `<b>Nº de Processo:</b><br>${localStorage.getItem("consult_process")}<br><br><b>Nº de Boletim:</b><br>${out.cod}<br><br><b>Codigo de Confirmacao:</b><br>${out.cod_confirmacao}`);
        } catch(e) {
          switch(data) {
            case "PROCESS_NUMBER_NOT_PROVIDED":
              alertify.warning("Nenhum nº de processo fornecido.");
              break;
            case "PROCESS_NUMBER_DOES_NOT_EXIST":
              alertify.warning("O nº de processo nao tem um boletim associado. Verifique se o nº de processo esta correto.");
              break;
            default:
              alertify.error("Ocorreu um erro inesperado.");
              break;
          }
        }
      });
    });

  </script>
</html>
