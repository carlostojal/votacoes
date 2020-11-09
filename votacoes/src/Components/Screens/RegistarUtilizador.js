import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import { useState } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function RegistarUtilizador() {

  const [username, setUsername] = useState(null);
  const [password, setPassword] = useState(null);
  const [registarLoading, setRegistarLoading] = useState(false);

  const onChange = (value, type) => {
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

  const onRegistar = () => {

    alertify.confirm("Registar Utilizador", `Confirma o registo do utilizador <b>${username}</b>?`, () => {

      setRegistarLoading(true);

      const formData = new FormData();
      formData.append("username", username);
      formData.append("password", password);

      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/createUser.php`, {
        method: "POST",
        credentials: "include",
        body: formData
      })
        .then(res => res.text())
        .then((result) => {
          setRegistarLoading(false);
          switch(result) {
            case "OK":
              alertify.success("Utilizador registado com sucesso.");
              break;
            default:
              alertify.error("Erro ao registar o utilizador.");
              break;
          }
        }, (error) => {
          alertify.error("Erro ao registar o utilizador. Por favor verifique a sua ligação à internet.")
        });
    }, () => {

    });
  }

  return (
    <AdminTemplate title="Registar Utilizador">
      <Form>
        <Form.Group>
          <Form.Label>Nome de utilizador</Form.Label>
          <Form.Control type="email" onChange={(e) => onChange(e.target.value, "username")} />
        </Form.Group>
        <Form.Group>
          <Form.Label>Palavra-passe</Form.Label>
          <Form.Control type="password" onChange={(e) => onChange(e.target.value, "password")} />
        </Form.Group>
        <Button onClick={onRegistar} disabled={registarLoading}>
          { registarLoading &&
            <Spinner animation="border" />
          }
          { !registarLoading &&
            <>Registar</>
          }
        </Button>
      </Form>
    </AdminTemplate>
  );
}