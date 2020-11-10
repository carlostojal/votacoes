import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import { useHistory } from "react-router-dom";
import alertify from "alertifyjs";
import { useEffect, useState } from "react";

import Template from "../Misc/Template";

export default function Listas() {

  const [listas, setListas] = useState([]);
  const [loading, setLoading] = useState(true);
  const history = useHistory();

  // get lists from backend on first render
  useEffect(() => {
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getListas.php`)
      .then(res => res.json())
      .then((result) => {
        setListas(result);
        setLoading(false);
      }, (error) => {
        alertify.error("Ocorreu um erro inesperado");
      });
  }, []);

  // when a vote button is pressed, navigate to the vote screen
  const onVotar = (lista) => {
    localStorage.setItem("lista", lista.id);
    history.push("/votar");
  }
  
  return (
    <Template title="Listas">
      { loading && 
        <Spinner animation="border" />
      }
      { !loading &&
        <Row>
          {listas.map((lista) => 
            <Col key={lista.id}>
              <Card style={{width: "18rem"}}>
                { lista.imagem &&
                  <Card.Img variant="top" src={`${process.env.REACT_APP_BACKEND_ADDRESS}/${lista.imagem}`} />
                }
                <Card.Body>
                  <Card.Title>{lista.nome}</Card.Title>
                  <Card.Text>{lista.descricao}</Card.Text>
                  <Button variant="primary" onClick={() => onVotar(lista)}>Votar</Button>
                </Card.Body>
              </Card>
            </Col>
          )}
        </Row>
      }
    </Template>
  );
}