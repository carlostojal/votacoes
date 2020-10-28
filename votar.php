<!DOCTYPE html>
<html>
  <head>
    <?php require("./head.php") ?>
    <title> Votar </title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar.php") ?>
    <div class="container">
      <div id="accordion">
        <div class="card">

          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                1. Pedido do Boletim
              </button>
            </h5>
          </div>

          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <div class="form-group">
                <label for="process_number">Nº de Processo</label>
                <input type="text" class="form-control" id="process_number" placeholder="aXXXX">
                <button id="register" class="btn btn-outline-primary">
                  <div id="register_spinner" class="spinner-border" role="status">
                    <span class="sr-only">Carregando...</span>
                  </div>
                  <span id="register_text">Pedir boletim</span>
                </button>
                <small class="form-text text-muted">O nº de boletim será enviado para o seu endereço de email institucional.</small>
              </div>
            </div>
          </div>
        </div>
        <div class="card">

          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                2. Voto
              </button>
            </h5>
          </div>

          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
              <div class="form-group">
                <label for="boletim">Nº de Boletim</label>
                <input type="number" class="form-control" id="boletim" placeholder="Introduza o seu nº de boletim">
                <small class="form-text text-muted">Este número foi enviado para o email institucional.</small>
              </div>
              <div class="form-group">
                <label for="codigo">Código de Confirmação</label>
                <input type="number" class="form-control" id="codigo" placeholder="Introduza o código de confirmação">
                <small class="form-text text-muted">Este número foi também enviado para o email institucional.</small>
              </div>
              <div class="form-group">
                <label for="lista">Lista</label>
                <div id="listas_spinner" class="spinner-border" role="status">
                  <span class="sr-only">Carregando...</span>
                </div>
                <select id="listas" class="form-control"></select>
              </div>
              <p class="text-muted">Apesar de estes dados serem pedidos, os boletins não
              são associados aos votos, pelo que os mesmos são anónimos.
              Estes dados são utilizados apenas para garantir o voto único.</p>
              <button id="vote" class="btn btn-primary">
                <div id="vote_spinner" class="spinner-border" role="status">
                  <span class="sr-only">Carregando...</span>
                </div>
                <span id="vote_text">Votar</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require("./footer.php") ?>
    <script>

      $("#register_spinner").hide();
      $("#vote_spinner").hide();
      $("#listas").hide();

      $("#process_number").val(localStorage.getItem("process_number"));
      $("#boletim").val(localStorage.getItem("code"));
      $("#codigo").val(localStorage.getItem("confirmation_code"));

      $.get("./api/getListas.php", (data) => {

        $("#listas").show();
        $("#listas_spinner").hide();

        const listas = JSON.parse(data);

        listas.map((lista) => {
          $("#listas").append(`
            <option ${lista.nome == localStorage.getItem("lista") ? "selected" : ""}>${lista.nome}</option>
          `);
        });

      });

      $("#process_number").on("input", () => {
        localStorage.setItem("process_number", $("#process_number").val());
      });

      $("#boletim").on("input", () => {
        localStorage.setItem("code", $("#boletim").val());
      });

      $("#codigo").on("input", () => {
        localStorage.setItem("confirmation_code", $("#codigo").val());
      });

      $("#listas").on("change", () => {
        localStorage.setItem("lista", $("#listas :selected").text());
      });


      $("#register").click(() => {

        const process_number = $("#process_number").val();

        alertify.confirm("Confirmar nº de processo", `O nº de processo está correto?<br><br><b>${process_number}</b>`, () => {
          $("#register_text").hide();
          $("#register_spinner").show();

          $.post("./api/registar.php", {process_number}, (data) => {
            $("#register_text").show();
            $("#register_spinner").hide();

            if(data == "OK")
              alertify.success("Boletim registado. Verifique o seu email institucional.");
            else if(data == "RESENT")
              alertify.success("Boletim reenviado. Verifique o seu email institucional.");
            else if(data == "PROCESS_NUMBER_NOT_PROVIDED")
              alertify.warning("Forneça um endereço de email.");
            else if(data == "ALREADY_VOTED")
              alertify.warning("Já votou.");
            else if(data == "REGISTER_BLOCKED")
              alertify.warning("Foi detetado um comportamento estranho, pelo que o seu registo foi bloqueado.");
            else
              alertify.error("Erro ao registar o boletim.");
          });
          $("#vote_area").show();
        }, () => {

        });        
      });

      $("#vote").click(() => {

        const process_number = $("#process_number").val();
        const boletim = $("#boletim").val();
        const codigo_confirmacao = $("#codigo").val();
        const lista = $("#listas :selected").text();

        alertify.confirm("Confirmar voto", `O aluno com nº de processo <b>${process_number}</b> e nº de boletim
          <b>${boletim}</b> irá registar o seu voto na lista <b>${lista}<b>.<br><br><b>Confirma?<b>`, () => {

            $("#vote_text").hide();
            $("#vote_spinner").show();
            
            $.post("./api/votar.php", {boletim, codigo_confirmacao, lista}, (data) => {

              $("#vote_text").show();
              $("#vote_spinner").hide();

              if(data == "OK")
                alertify.alert("Sucesso", "Voto registado com sucesso.", () => {
                  window.location = "./index.php";
                });
              else if(data == "NOT_REGISTERED")
                alertify.warning("Este nº de boletim não existe.");
              else if(data == "INVALID_CODE")
                alertify.warning("Nº de Boletim inválido.");
              else if(data == "WRONG_CONFIRMATION_CODE")
                alertify.warning("Código de confirmação inválido.");
              else if(data == "ALREADY_VOTED")
                alertify.warning("Já votou.");
              else
                alertify.error("Erro ao registar o voto.");

            });
          }, () => {

          });
      });

    </script>
  </body>
</html>
