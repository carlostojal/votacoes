import Template from "../Misc/Template";

export default function Sobre() {
  return (
    <Template title="Sobre">
      <p>Tal como no voto tradicional, o mesmo é anónimo.</p>
      <p>
        A cada endereço de email institucional é associado um nº de boletim que
        contém um código de confirmação para assegurar que cada aluno não
        consiga utilizar o boletim de outro. O endereço de email encontra-se
        devidamente encriptado na base de dados.
      </p>
      <p>
        Ao votar, é registado na base de dados o voto e a respetiva data e hora
        sem qualquer associação ao boletim.
        O boletim é inutilizado.
      </p>
      <p>
        Assim, cada boletim só tem uma utilização válida, e não é possível
        saber por quem foram registados os votos.
      </p>
      <h3>Tecnologias usadas</h3>
      <br></br>
      <h4>Frontend</h4>
      <ul>
        <li>ReactJS</li>
        <li>React Bootstrap</li>
        <li>AlertifyJS</li>
        <li>Chart.js</li>
      </ul>
      <h4>Backend</h4>
      <ul>
        <li>PHP</li>
        <li>MySQL</li>
        <li>PHPMailer</li>
      </ul>
      <a href="https://github.com/carlostojal/votacoes">Código</a>
    </Template>
  );
}