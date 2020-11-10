import Nav from "react-bootstrap/Nav";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import { Link, useHistory } from "react-router-dom";
import { useState } from "react";

export default function AdminNav() {

  const [logoutLoading, setLogoutLoading] = useState(false);

  const history = useHistory();

  const onLogout = () => {
    setLogoutLoading(true);
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/logout.php`, {
      credentials: "include"
    })
      .then(res => res.text())
      .then((result) => {
        if(result === "OK")
          history.push("/");
        else
          alertify.error("Ocorreu um erro.")
      }, (error) => {
        alertify.error("Ocorreu um erro inesperado. Verifique a sua ligação à internet.")
      });
  }

  return (
    <Nav className="flex-column">
      <Nav.Link as={Link} to="/listas_admin">Listas</Nav.Link>
      <Nav.Link as={Link} to="/estatistica">Estatística</Nav.Link>
      <Nav.Link as={Link} to="/config">Configurações</Nav.Link>
      <Nav.Link as={Link} to="/registar_utilizador">Registar Utilizador</Nav.Link>
      <Nav.Link as={Link} to="/consultar_boletim">Consultar Boletim</Nav.Link>
      <Nav.Link onClick={onLogout}>
        Terminar Sessão
        { logoutLoading &&
          <Spinner animation="border" />
        }
      </Nav.Link>
    </Nav>
  );
}