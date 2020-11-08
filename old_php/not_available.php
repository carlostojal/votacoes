<html>
  <head>
    <?php require("./head.php") ?>
    <title>Nao disponivel</title>
  </head>
  <body>
    <?php require("./credits.php") ?>
    <?php require("./navbar.php") ?>
    <div class="jumbotron">
      <h1 class="display-4">Não disponível</h1>
      <p class="lead" id="cause"></p>
      <hr class="my-4">
      <p class="text-muted" id="details"></p>
    </div>
    <?php require("./footer.php") ?>
  </body>
  <script>

    const searchParams = new URLSearchParams(window.location.search)

    const cause = searchParams.get("cause");
    const extra = searchParams.get("extra");
    let cause_text = "";
    let details = "";
    let extra_date = null;

    if(extra)
      extra_date = new Date(parseInt(extra));

    switch(cause) {
      case "too_early":
        cause_text = "As eleições ainda não estão disponíveis.";
        details = `As eleições estarão disponíveis ${extra_date.getDate()}/${extra_date.getMonth() + 1} as ${extra_date.getHours()}:${extra_date.getMinutes()}.`;
        break;
      case "too_late":
        cause_text = "As eleições já terminaram.";
        details = `As eleições terminaram ${extra_date.getDate()}/${extra_date.getMonth() + 1} as ${extra_date.getHours()}:${extra_date.getMinutes()}.`;
        break;
    }

    $("#cause").text(cause_text);
    $("#details").text(details);
  </script>
</html>
