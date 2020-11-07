import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

import MyNavbar from "../Misc/MyNavbar";
import AdminNav from "../Misc/AdminNav";
import Footer from "../Misc/Footer";

export default function Admin() {
  return (
    <>
      <MyNavbar />
      <Container fluid>
        <Row>
          <Col className="col-sm-2">
            <AdminNav />
          </Col>
          <Col className="col-sm-10">
            <Jumbotron>
              <h1 className="display-4">Área administrativa</h1>
            </Jumbotron>
            <Container fluid>
              <p>Esta é a área que permite administrar o processo eleitoral.</p>
              <p>Na barra de navegação lateral encontra-se o menu de opções administrativas.</p>
              <p>Segue-se uma breve explicação das mesmas:</p>
              <ul>
                <li>
                  <b>Listas:</b> Aqui criam-se e eliminam-se as listas candidatas.
                </li>
                <li>
                  <b>Estatística:</b> Aqui encontram-se as estatísticas das votações.
                </li>
                <li>
                  <b>Configurações:</b> Aqui configura-se a data e hora de começo e fim das votações, assim como se as estatísticas deverão ficar publicamente visíveis no fim das mesmas.
                </li>
              </ul>
            </Container>
            <Footer />    
          </Col>
        </Row>
      </Container>
    </>
  );
}