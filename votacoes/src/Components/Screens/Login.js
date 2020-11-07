import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import { useState } from "react";

import MyNavbar from "../Misc/MyNavbar";
import Footer from "../Misc/Footer";

export default function Login() {

  const [loginLoading, setLoginLoading] = useState(false);
  const [username, setUsername] = useState(null);
  const [password, setPassword] = useState(null);

  const onLogin = () => {
    setLoginLoading(true);
    console.log(username);
    console.log(password);
  }

  const onFieldChange = (value, type) => {
    switch(type) {
      case "username":
        setUsername(value);
        break;
      case "password":
        setPassword(value);
        break;
      default:
        setUsername(null);
        setPassword(null);
        break;
    }
  }

  return (
    <>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">Início de Sessão</h1>
      </Jumbotron>
      <Container>
        <Form>
          <Form.Group>
            <Form.Label>Nome de utilizador</Form.Label>
            <Form.Control type="email" onChange={(e) => onFieldChange(e.target.value, "username")} />
          </Form.Group>
          <Form.Group>
            <Form.Label>Palavra-passe</Form.Label>
            <Form.Control type="password" onChange={(e) => onFieldChange(e.target.value, "password")} />
          </Form.Group>
          <Button variant="primary" disabled={loginLoading} onClick={onLogin}>
            { loginLoading &&
              <Spinner animation="border" />
            }
            { !loginLoading &&
              <>Iniciar Sessão</>
            }
          </Button>
        </Form>
      </Container>
      <Footer />
    </>
  );
}