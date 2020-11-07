import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";

import MyNavbar from "../Misc/MyNavbar";
import Footer from "../Misc/Footer";

export default function Sobre() {
  return (
    <>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">Sobre</h1>
      </Jumbotron>
      <Container fluid>
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
          <li>Bootstrap</li>
        </ul>
        <h4>Backend:</h4>
        <ul>
          <li>PHP</li>
          <li>MySQL</li>
        </ul>
      </Container>
      <Footer />
    </>
  );
}