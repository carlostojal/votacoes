import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";

import MyNavbar from "./MyNavbar";
import Footer from "./Footer";

export default function Template(props) {
  return (
    <>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">{props.title}</h1>
        <p className="lead">{props.description}</p>
      </Jumbotron>
      <Container fluid>
        {props.children}
      </Container>
      <Footer />
    </>   
  );
}