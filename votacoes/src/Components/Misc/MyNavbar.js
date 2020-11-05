import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import { Link } from "react-router-dom";

export default function MyNavbar() {
 return (
  <Navbar expand="lg">
    <Navbar.Brand as={Link} to={"/"}>Eleições</Navbar.Brand>
    <Navbar.Toggle />
    <Navbar.Collapse>
      <Nav className="mr-auto">
        <Nav.Link as={Link} to={"/listas"}>Listas</Nav.Link>
        <Nav.Link as={Link} to={"/admin"}>Área administrativa</Nav.Link>
      </Nav>
    </Navbar.Collapse>
  </Navbar>
 );
}