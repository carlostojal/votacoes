<html>
  <head>
    <?php require("./head.php") ?>
    <title> Início de Sessão na Área Administrativa </title>
  </head>
  <body>
    <?php require("./credits.php") ?>
      <div class="jumbotron">
        <h1>Início de Sessão na Area Administrativa</h1>
      </div>
      <div class="container">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Introduza o seu nome de utilizador">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Introduza a sua password">
        </div>
        <button id="login" class="btn btn-primary">
          <div id="login_spinner" class="spinner-border" role="status">
            <span class="sr-only">Carregando...</span>
          </div>
          <span id="login_text">Iniciar Sessão</span>
        </button>
      </div>
    <?php require("./footer.php") ?>
  </body>
  <script>

    $("#login_spinner").hide();

    $("#login").click(() => {

      const username = $("#username").val();
      const password = $("#password").val();

      $.post("./api/login.php", {username, password}, (data) => {

        if(data == "OK")
          window.location.replace("./admin.php");
        else if(data == "USERNAME_NOT_PROVIDED")
          alertify.warning("Username não fornecido.");
        else if(data == "PASSWORD_NOT_PROVIDED")
          alertify.warning("Password não fornecida.");
        else if(data == "WRONG_CREDENTIALS")
          alertify.warning("Credenciais erradas.");
        else
          alertify.error("Ocorreu um erro a iniciar sessão.");
      });
    });
  </script>
</html>
