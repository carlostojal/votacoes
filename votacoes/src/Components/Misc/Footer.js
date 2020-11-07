import Container from "react-bootstrap/Container";

export default function Footer() {
  return (
    <Container fluid={true}>
      <p className="text-muted">
        Desenvolvido por Carlos Tojal em colaboração com a 
        Comissão Eleitoral 2020-2021 &copy; {new Date().getFullYear()}
      </p>
    </Container>
  );
}