<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow">
  <a class="navbar-brand" href="admin.php">Área administrativa</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="listas_admin.php">Listas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="config.php">Configurações</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="estatistica.php">Estatística</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="consultar_boletim.php">Consultar Boletim</a>
      </li>
    </ul>
    <button id="logout" class="btn btn-primary" href="logout.php">
      <div id="logout_spinner" class="spinner-border" role="status">
        <span class="sr-only">Carregando...</span>
      </div>
      <span id="logout_text">Logout</span>
    </button>
  </div>
</nav>
<script>

  $("#logout_spinner").hide();

  $("#logout").click(() => {

    $("#logout_text").hide();
    $("#logout_spinner").show();

    $.get("./api/logout.php", () => {
      window.location = "./index.php";
    });

  });
</script>
