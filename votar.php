<html>
  <head>
    <?php require("./head.php") ?>
    <title> Votações </title>
  </head>
  <body>
    <?php require("./navbar.php") ?>
    <div class="container">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Introduza o seu endereço de email">
        <button id="register" class="btn btn-outline-primary">
          <div id="register_spinner" class="spinner-border" role="status">
            <span class="sr-only">Carregando...</span>
          </div>
          <span id="register_text">Registar boletim</span>
        </button>
        <small class="form-text text-muted">O nº de boletim será enviado para o seu endereço de email.</small>
      </div>
      <div id="vote_area">
        <div class="form-group">
          <label for="boletim">Nº de Boletim</label>
          <input type="password" class="form-control" id="boletim" placeholder="Introduza o seu nº de boletim">
          <small class="form-text text-muted">O nº de boletim foi enviado para o seu endereço de email.</small>
        </div>
        <button class="btn btn-primary">Votar</button>
      </div>
    </div>
    <script>

      $("#vote_area").hide();
      $("#register_spinner").hide();


      $("#register").click(() => {

        $("#register_text").hide();
        $("#register_spinner").show();

        const email = $("#email").val();

        $.post("api/registar.php", {email}, () => {
          $("#register_text").show();
          $("#register_spinner").hide();
        });

        $("#vote_area").show();
      });
    </script>
  </body>
</html>