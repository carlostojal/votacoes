import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Spinner from "react-bootstrap/Spinner";
import { useHistory } from "react-router-dom";
import { useState } from "react";

import MyNavbar from "../Misc/MyNavbar";
import AdminNav from "../Misc/AdminNav";
import Footer from "../Misc/Footer";
import SessionChecker from "../Misc/SessionChecker";

export default function AdminTemplate(props) {

  const [sessionLoading, setSessionLoading] = useState(true);
  const [isAllowed, setIsAllowed] = useState(false);

  const history = useHistory();

  const onSessionCheck = (isLogged) => {
    setIsAllowed(isLogged);
    setSessionLoading(false);
  };

  return (
    <>
      <SessionChecker onCheck={onSessionCheck.bind(this)} />
      <MyNavbar />
      <Container fluid>
        { sessionLoading &&
          <Spinner animation="border" />
        }
        { !sessionLoading && !isAllowed &&
          history.replace("/login")
        }
        { !sessionLoading && isAllowed &&
          <Row>
            <Col className="col-sm-3">
              <AdminNav />
            </Col>
            <Col className="col-sm-11">
              <Jumbotron>
                <h1 className="display-4">{props.title}</h1>
                <p className="lead">{props.description}</p>
              </Jumbotron>
              <Container fluid>
                {props.children}
              </Container>
              <Footer />    
            </Col>
          </Row>
        }
      </Container>
    </>
  );
}