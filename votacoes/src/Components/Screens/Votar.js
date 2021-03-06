import Form from "react-bootstrap/Form";
import Spinner from "react-bootstrap/Spinner";
import Button from "react-bootstrap/Button";
import alertify from "alertifyjs";
import { useHistory } from "react-router-dom";

import Template from "../Misc/Template";

import {useEffect, useState} from "react";

export default function Votar(props) {

  const [isAllowed, setIsAllowed] = useState(false);
  const [isAllowedLoading, setIsAllowedLoading] = useState(true);
  const [notAllowedCause, setNotAllowedCause] = useState(null);
  const [lista, setLista] = useState({});
  const [listas, setListas] = useState(null);
  const [loadingListas, setLoadingListas] = useState(true);
  const [loadingVoto, setLoadingVoto] = useState(false);

  const [nBoletim, setNBoletim] = useState(null);
  const [codigoConfirmacao, setCodigoConfirmacao] = useState(null);

  const history = useHistory();

  // get selected list from history props on first render
  useEffect(() => {
    if(props.location.state && props.location.state.lista)
      setLista(props.location.state.lista);
    else
      setLista({});
  }, []);

  // get config on first render (will determine if voting is allowed or not)
  useEffect(() => {
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getConfig2.php`)
      .then(res => res.json())
      .then((result) => {
        // voting has not started yet
        if(Date.now() < result.votes_start) {
          setNotAllowedCause("As votações ainda não começaram.");
        } else if(Date.now() > result.votes_end) { // voting has ended
          setNotAllowedCause("As votações já terminaram.");
        } else {
          setIsAllowed(true);
        }
        setIsAllowedLoading(false);
      });
  }, []);

  // get lists from backend (only when config was already loaded, to avoid unneccessary requests on the client)
  useEffect(() => {
    if(isAllowed) {
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getListas.php`)
        .then(res => res.json())
        .then((result) => {
          setListas(result);
          setLoadingListas(false);
        }, (error) => {
          alertify.error("Ocorreu um erro inesperado.");
        });
    }
  }, [isAllowed]);

  // when selected list is changed
  const onListaChange = (listaSelecionada) => {
    if(lista) {
      if(listaSelecionada.id === lista.id) {
        listaSelecionada = {};
      }
    }
    setLista(listaSelecionada);
  }

  // when some field is changed (type indicates which field was changed)
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

  // when vote button is pressed
  const onVote = () => {
    if(!nBoletim || nBoletim === "") {
      alertify.warning("Não foi fornecido um nº de boletim.");
      return;
    }
    if(!codigoConfirmacao || codigoConfirmacao === "") {
      alertify.warning("Não foi fornecido um código de confirmação.");
      return;
    }
    // alert to confirm vote
    alertify.confirm("Confirmar voto", `
      <b>Nº de Boletim:</b><br>
      ${nBoletim}<br><br>
      <b>Código de Confirmação:</b><br>
      ${codigoConfirmacao}<br><br>
      <b>Lista:</b><br>
      ${lista.nome || "(Voto branco)"}
    `, () => { // vote was confirmed
      setLoadingVoto(true);
      // create the form
      let formData = new FormData();
      formData.append("boletim", nBoletim);
      formData.append("codigo_confirmacao", codigoConfirmacao);
      formData.append("lista", lista.id || null);
      // register the vote
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/votar.php`, {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then((result) => {
        setLoadingVoto(false);
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
            alertify.success("Sucesso", "Voto registado com sucesso.");
            break;
          default:
            alertify.error("Ocorreu um erro.");
            break;
        }
      }, (err) => {
        alertify.error("Ocorreu um erro inesperado.");
      });
    }, () => {

    });
  }

  return (
    <Template title="Votar">
      { isAllowedLoading &&
        <Spinner animation="border" />
      }
      { !isAllowedLoading && isAllowed &&
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
              listas.map((listaAtual) => {
                let selected = false;
                if(lista && lista.id) {
                  if(lista.id == listaAtual.id)
                    selected = true;
                }
                return <Form.Check key={listaAtual.id} type="checkbox" label={listaAtual.nome} checked={selected} onChange={() => onListaChange(listaAtual)} />
              })
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
      }
      { !isAllowedLoading && !isAllowed &&
        history.push({
          pathname: "/nao_permitido",
          cause: notAllowedCause
        })
      }
    </Template>
  );
}