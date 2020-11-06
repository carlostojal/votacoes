import Jumbotron from "react-bootstrap/Jumbotron";

import MyNavbar from "../Misc/MyNavbar";
import Footer from "../Misc/Footer";

export default function NaoPermitido(props) {
  return (
    <>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">Não permitido</h1>
        <p className="lead">{props.location.cause }</p>
      </Jumbotron>
      <Footer />
    </>
  );
}