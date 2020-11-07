import Nav from "react-bootstrap/Nav";
import { Link } from "react-router-dom";

export default function AdminNav() {
  return (
    <Nav className="flex-column">
      <Nav.Link as={Link} to="/listas_admin">Listas</Nav.Link>
      <Nav.Link as={Link} to="/estatistica">Estatística</Nav.Link>
      <Nav.Link as={Link} to="/config">Configurações</Nav.Link>
    </Nav>
  );
}