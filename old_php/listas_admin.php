
<?php
  
  session_start();
  
  if(!isset($_SESSION['username']))
    header("Location: login.php");
?>
<html>
  <head>
    <?php require("./head.php") ?>
    <title>Listas - Área Administrativa</title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar_admin.php") ?>
    <div class="jumbotron">
      <h1 class="display-4">Administração de Listas</h1>
    </div>
    <div class="container-fluid">
      <button id="add" class="btn btn-primary">
        <div class="spinner-border" role="status" id="spinner_add">
          <span class="sr-only">Carregando...</span>
        </div>
        <span id="text_add">Adicionar Lista</span>
      </button>
    </div>
    <form id="form">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="name" placeholder="Introduza o nome da lista">
      </div>
      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" rows="5" id="descricao" name="description" placeholder="Introduza a descricao da lista"></textarea>
      </div>
      <div class="form-group">
        <label for="imagem">Imagem</label>
        <input type="file" accept="image/*" class="form-control" id="imagem" name="img" placeholder="Introduza a imagem da lista"></textarea>
      </div>
    </form>
  </body>
  <?php require("./alertify_config.php") ?>
  <script>

    $("#spinner_add").hide();
    
    if(!alertify.newLista) {
      alertify.dialog('newLista', function() {
        return {
          main: function(form) {
            this.form = form;
          },
          setup: function() {
            return {
              buttons: [{text: "Adicionar"}, {text: "Cancelar"}],
              options: {
                title: "Adicionar Lista"
              }
            };
          },
          prepare: function() {
            this.setContent(this.form);
          },
          callback: function(e) {

            if(e.index == 0) {

              $("#text_add").hide();
              $("#spinner_add").show();

              let formData = new FormData();

              formData.append("name", $("#nome").val());
              formData.append("description", $("#descricao").val());
              try {
                if($("#imagem")[0].files.length > 0)
                  formData.append("img", $("#imagem")[0].files[0]);
              } catch(e) {
                console.log(e);
              }

              console.log(formData.values());

              for(let value of formData.values())
                console.log(value);

              $.ajax({
                url: "./api/addLista.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (data) => {

                  $("#text_add").show();
                  $("#spinner_add").hide();
                  
                  switch(data) {
                    case "OK":
                      alertify.success("Lista adicionada com sucesso.");
                      break;
                    case "NAME_NOT_PROVIDED":
                      alertify.warning("Nao foi fornecido um nome.");
                      break;
                    case "DESCRIPTION_NOT_PROVIDED":
                      alertify.warning("Nao foi fornecida uma descricao.");
                      break;
                    default:
                      alertify.error("Ocorreu um erro ao tentar adicionar a lista. Por favor tente novamente.");
                      break;
                  }
                }
              });
            }
          }
        };
      });
    }

    $("#form").hide();

    $("#add").click(() => {
      $("#form").show();
      alertify.newLista($("#form")[0]).resizeTo("50%", "80%");
    });

  </script>
</html>
