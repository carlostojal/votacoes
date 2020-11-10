import Template from "../Misc/Template";

export default function Sobre() {
  return (
    <Template title="Sobre">
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
      <a href="https://github.com/carlostojal/votacoes">Código</a>
    </Template>
  );
}