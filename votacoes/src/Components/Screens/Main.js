import Jumbotron from "react-bootstrap/Jumbotron";
import Button from "react-bootstrap/Button";
import MyNavbar from "../Misc/MyNavbar";

export default function Main() {
  return (
    <div>
      <MyNavbar />
      <Jumbotron>
        <h1 className="display-4">Eleição AE AERBP { new Date().getFullYear() }</h1>
        <p className="lead">O processo eleitoral renovado.</p>
        <hr className="my-4" />
        <p>
          <Button variant="primary">Listas</Button>
        </p>
      </Jumbotron>
    </div>
  );
}