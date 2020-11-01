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
    <?php require("./footer.php") ?>
    <script>

      function onVote(lista) {
        localStorage.setItem("lista", lista);
        window.location = "./votar.php";
      }

      $.get("./api/getListas.php", (data) => {

        $("#spinner").remove();

        const listas = JSON.parse(data);

        if(listas.length == 0)
          $("#area_listas").append("Nenhuma lista.");

        listas.map((lista) => {

          $("#area_listas").append(`
            <div class="col">
              <div class="card lista" style="width: 18rem">
                <span onclick="onVote('${lista.id}')" style="cursor: pointer">
                  <img class="card-img-top" src="./${lista.imagem ? lista.imagem : "img/aerbp.jpeg"}" style="height: 10rem, width: auto">
                  <div class="card-body">
                    <h5 class="card-title">${lista.nome}</h5>
                    <p class="card-text">${lista.descricao}</p>
                    <button class="btn btn-primary" onclick="onVote('${lista.id}')">Votar</button>
                  </div>
                </span>
              </div>
            </div>
          `);
        });
      });

    </script>
  </body>
</html>
