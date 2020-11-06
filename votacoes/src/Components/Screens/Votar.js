import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";
import Form from "react-bootstrap/Form";
import Spinner from "react-bootstrap/Spinner";
import Button from "react-bootstrap/Button";
import alertify from "alertifyjs";

import MyNavbar from "../Misc/MyNavbar";
import Footer from "../Misc/Footer";

import {useEffect, useState} from "react";

export default function Votar() {

  const [lista, setLista] = useState(null);
  const [listas, setListas] = useState(null);
  const [loadingListas, setLoadingListas] = useState(true);
  const [loadingVoto, setLoadingVoto] = useState(false);

  const [nBoletim, setNBoletim] = useState(null);
  const [codigoConfirmacao, setCodigoConfirmacao] = useState(null);

  useEffect(() => {
    setLista(JSON.parse(localStorage.getItem("lista")));
  }, []);

  useEffect(() => {
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getListas.php`)
      .then(res => res.json())
      .then((result) => {
        setListas(result);
        setLoadingListas(false);
      }, (error) => {
        alertify.error("Ocorreu um erro inesperado.");
      });
  }, []);

  const onListaChange = (listaSelecionada) => {
    setLista(listaSelecionada);
    localStorage.setItem("lista", JSON.stringify(listaSelecionada));
  }

  const onFieldChange = (value, field) => {
    switch(field) {
      case "nBoletim":
        setNBoletim(value);
        break;
      case "codigoConfirmacao":
        setCodigoConfirmacao(value);
        break;
      default:
        setCodigoConfirmacao(null);
        break;
    }
  }

  const onVote = () => {
    alertify.confirm("Confirmar voto", `
      <b>Nº de Boletim:</b><br>
      ${nBoletim}<br><br>
      <b>Código de Confirmação:</b><br>
      ${codigoConfirmacao}<br><br>
      <b>Lista:</b><br>
      ${lista.nome}
    `, () => {
      setLoadingVoto(true);
      let formData = new FormData();
      formData.append("boletim", nBoletim);
      formData.append("codigo_confirmacao", codigoConfirmacao);
      formData.append("lista", lista);
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/votar.php`, {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then((result) => {
        setLoadingVoto(false);
        try {
          result = JSON.parse(result);
        } catch(e) {
          switch(result) {
            case "NOT_REGISTERED":
              alertify.warning("Este boletim não foi registado.");
              break;
            case "WRONG_CONFIRMATION_CODE":
              alertify.warning("Código de confirmação errado.");
              break;
            case "ALREADY_VOTED":
              alertify.warning("Já votou.");
              break;
            case "OK":
              alertify.message("Sucesso", "Voto registado com sucesso.");
              break;
            default:
              alertify.error("Ocorreu um erro.");
              break;
          }
        }
      }, (err) => {
        alertify.error("Ocorreu um erro inesperado.");
      });
    }, () => {

    });
  }

  return (
    <>
      <MyNavbar />
      <Jumbotron>
          <h1 className="display-4">Votar</h1>
      </Jumbotron>
      <Container>
        <Form>
          <Form.Group>
            <Form.Label>Nº de Boletim</Form.Label>
            <Form.Control type="number" onChange={(e) => onFieldChange(e.target.value, "nBoletim")} />
          </Form.Group>
          <Form.Group>
            <Form.Label>Código de confirmação</Form.Label>
            <Form.Control type="number" onChange={(e) => onFieldChange(e.target.value, "codigoConfirmacao")} />
          </Form.Group>
          <Form.Group>
            <Form.Label>Voto</Form.Label>
            { loadingListas &&
              <Spinner animation="border" />
            }
            { !loadingListas &&
              listas.map((listaAtual) =>
                <Form.Check key={listaAtual.id} type="checkbox" label={listaAtual.nome} checked={lista.id === listaAtual.id} onChange={() => onListaChange(listaAtual)} />
              )
            }
          </Form.Group>
          <Button variant="primary" onClick={onVote} disabled={loadingVoto}>
            { loadingVoto &&
              <Spinner animation="border" />
            }
            { !loadingVoto && 
              <>Votar</>
            }
          </Button>
        </Form>
      </Container>
      <Footer />
    </>
  );
}