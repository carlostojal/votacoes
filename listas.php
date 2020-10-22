<html>
  <head>
    <?php require("./head.php") ?>
    <title> Listas </title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar.php") ?>
    <div class="container-fluid">
      <div id="spinner" class="spinner-border" role="status">
        <span class="sr-only">Carregando...</span>
      </div>
      <div id="area_listas" class="row">
      </div>
    </div>
    <script>

      function onVote(lista) {
        localStorage.setItem("lista", lista);
        window.location = "./votar.php";
      }

      $.get("./api/getListas.php", (data) => {

        $("#spinner").remove();

        const listas = JSON.parse(data);

        listas.map((lista) => {
          $("#area_listas").append(`
            <div class="col col-sm-3">
              <div class="card" style="width: 18rem">
                <img class="card-img-top" src="img/img.svg">
                <div class="card-body">
                  <h5 class="card-title">${lista.nome}</h5>
                  <p class="card-text">${lista.descricao}</p>
                  <button class="btn btn-primary" onclick="onVote('${lista.nome}')">Votar</button>
                </div>
              </div>
            </div>
          `);
        });
      });

    </script>
  </body>
</html>