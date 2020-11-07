import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import { useHistory } from "react-router-dom";
import { useState } from "react";

import MyNavbar from "../Misc/MyNavbar";
import Footer from "../Misc/Footer";

export default function Login() {

  const [loginLoading, setLoginLoading] = useState(false);
  const [username, setUsername] = useState(null);
  const [password, setPassword] = useState(null);

  const history = useHistory();

  const onLogin = () => {

    setLoginLoading(true);

    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/login.php`, {
      method: "POST",
      credentials: "include",
      body: formData
    })
      .then(res => res.text())
      .then((result) => {
        setLoginLoading(false);
        switch(result) {
          case "WRONG_CREDENTIALS":
            alertify.warning("Credenciais erradas.");
            break;
          case "OK":
            history.replace("/admin");
            break;
          default:
            alertify.error("Ocorreu um erro.");
            break;
        }
      }, (error) => {
        alertify.error("Ocorreu um erro inesperado. Verifique a sua ligação à internet.");
        setLoginLoading(false);
      });
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