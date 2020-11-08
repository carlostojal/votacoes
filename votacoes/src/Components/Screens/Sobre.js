import Template from "../Misc/Template";

export default function Sobre() {
  return (
    <Template title="Sobre">
      <p>
        Em tempo pandemia de COVID-19, surgiu a necessidade de criar
        alternativas digitais para problemas que anteriormente 
        se resolviam fisicamente.
      </p>
      <p>
        Foi nesse sentido que surgiu a ideia de criar um portal de voto
        eletrónico, aproveitando também para modernizar este processo,
        que é trabalhoso na contagem de votos.
      </p>
      <br></br><br></br>
      <h3>Tecnologias usadas:</h3>
      <br></br>
      <h4>Frontend:</h4>
      <ul>
        <li>ReactJS</li>
        <li>React Bootstrap</li>
        <li>AlertifyJS</li>
        <li>Chart.js</li>
      </ul>
      <h4>Backend:</h4>
      <ul>
        <li>PHP</li>
        <li>MySQL</li>
        <li>PHPMailer</li>
      </ul>
    </Template>
  );
}