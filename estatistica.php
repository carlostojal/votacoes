<html>
  <?php

    session_start();

    if(!isset($_SESSION["username"]))
      header("location: ./login.php");

  ?>
  <head>
    <?php require("./head.php") ?>
    <script src="./libs/chartjs/package/dist/Chart.js"></script>
    <link rel="stylesheet" href="./libs/chartjs/package/dist/Chart.css"/>
    <title> Estatística </title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar_admin.php") ?>
    <div class="jumbotron">
      <h1 id="winner" class="display-4">Carregando vencedor...</h1>
      <p id="winner_votes" class="lead">Carregando nº de votos...</p>
    </div>
    <div class="container">
      <canvas id="graficoCircular"></canvas>
      <canvas id="graficoBarras"></canvas>
    </div>
    <div class="container">
      <table id="table" class="table">
        <tr>
          <th>Nome</th>
          <th>Nº de Votos</th>
          <th>Percentagem</th>
        </tr>
      </table>
    </div>
    <script>

      var votes;

      $.get("./api/getVotes.php", (data) => {

        votes = JSON.parse(data);

        let n_votos = [];
        let labels = [];
        let votes_sum = 0;
        let colors = [];
        let max = 0;
        votes.map((lista) => {
          n_votos.push(lista.n_votos);
          labels.push(lista.nome);
          votes_sum += parseInt(lista.n_votos);
          colors.push(`rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)})`);

          if(lista.n_votos > max) {
            $("#winner").text(`Vencedor: ${lista.nome}`);
            $("#winner_votes").text(`${lista.n_votos} votos`);
            max = lista.n_votos;
          }
        });

        votes.map((lista) => {
          $("#table").append(`
            <tr>
              <td>${lista.nome}</td>
              <td>${lista.n_votos}</td>
              <td>${((lista.n_votos / votes_sum) * 100).toFixed(2)}%</td>
            </tr>
          `);
        });

        $("#table").append(`
            <tr>
              <td></td>
              <td><b>${votes_sum}<b></td>
              <td></td>
            </tr>
          `);

        const ctxGraficoCircular = document.getElementById("graficoCircular").getContext("2d");

        const graficoCircular = new Chart(ctxGraficoCircular, {
          type: "pie",
          data: {
            labels: labels,
            datasets: [{
              label: "Nº de votos",
              data: n_votos,
              backgroundColor: colors
            }]
          }
        });

        /*
        const ctxGraficoBarras = document.getElementById("graficoBarras").getContext("2d");

        const graficoBarras = new Chart(ctxGraficoBarras, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [{
              label: "Nº de votos",
              data: n_votos,
              backgroundColor: colors
            }]
          }
      }); */

      });

    </script>
  </body>
</html>
