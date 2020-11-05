import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Jumbotron from "react-bootstrap/Jumbotron";
import Card from "react-bootstrap/Card";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import "alertifyjs/build/css/alertify.css";
import { useEffect, useState } from "react";

import MyNavbar from "../Misc/MyNavbar";

export default function Listas() {

  const [listas, setListas] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost/api/getListas.php")
      .then(res => res.json())
      .then((result) => {
        setListas(result);
        setLoading(false);
      }, (error) => {
        alertify.error("Ocorreu um erro inesperado");
      });
  }, []);
  
  return (
    <div>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">Listas</h1>
      </Jumbotron>
      { loading && 
        <Spinner />
      }
      { !loading &&
        <Row>
          {listas.map((lista) => 
            <Col>
              <Card style={{width: "18rem"}}>
                <Card.Img variant="top" src={lista.imagem} />
                <Card.Body>
                  <Card.Title>{lista.nome}</Card.Title>
                  <Card.Text>{lista.descricao}</Card.Text>
                </Card.Body>
              </Card>
            </Col>
          )}
        </Row>
      }
    </div>
  );
}