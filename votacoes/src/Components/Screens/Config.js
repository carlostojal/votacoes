import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import { useState, useEffect } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function Config() {

  const [shouldLoadConfig, setShouldLoadConfig] = useState(true);
  const [configLoading, setConfigLoading] = useState(true);
  const [configSaveLoading, setConfigSaveLoading] = useState(false);
  const [votesStart, setVotesStart] = useState(new Date());
  const [votesEnd, setVotesEnd] = useState(new Date());

  useEffect(() => {
    if(shouldLoadConfig) {
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getConfig2.php`)
        .then(res => res.text())
        .then((result) => {
          setConfigLoading(false);
          try {
            result = JSON.parse(result);
            setVotesStart(new Date(parseInt(result.votes_start)));
            setVotesEnd(new Date(parseInt(result.votes_end)));
          } catch(e) {
            alertify.error("Ocorreu um erro ao obter a configuração.");
          }
        }, (error) => {
          alertify.error("Ocorreu um erro ao obter a configuração. Verifique a sua ligação à internet.");
        });
    }
  }, [shouldLoadConfig]);

  const onDateChange = (value, type) => {
    console.log(value);
    const val = new Date(value);
    console.log(val);
    switch(type) {
      case "start":
        setVotesStart(val);
        break;
      case "end":
        setVotesEnd(val);
        break;
      default:
        setVotesStart(null);
        setVotesEnd(null);
        break;
    }
  }

  const formatDate = (date) => {
    const year = date.getFullYear();
    let month = (date.getMonth() + 1);
    month = month < 10 ? "0" + month : month;
    let day = date.getDate();
    day = day < 10 ? "0" + day : day;
    let hours = date.getHours();
    hours = hours < 10 ? "0" + hours : hours;
    let minutes = date.getMinutes();
    minutes = minutes < 10 ? "0" + minutes : minutes;
    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  const onConfigSave = () => {
    alertify.confirm("Salvar configurações", "Tem a certeza que pretende aplicar as configurações?", () => {

      setConfigSaveLoading(true);

      const formData = new FormData();
      formData.append("votes_start", new Date(votesStart).getTime());
      formData.append("votes_end", new Date(votesEnd).getTime());

      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/updateConfig.php`, {
        method: "POST",
        credentials: "include",
        body: formData
      })
        .then(res => res.text())
        .then((result) => {
          setConfigSaveLoading(false);
          switch(result) {
            case "OK":
              alertify.success("Configurações salvas com sucesso.");
              setShouldLoadConfig(true);
              break;
            default:
              alertify.error("Ocorreu um erro ao salvar as alterações.");
              break;
          }
        }, (error) => {
          console.log(error);
          alertify.error("Ocorreu um erro ao salvar as alterações. Verifique a sua ligação à internet.");
        });
    }, () => {

    });
  }

  return (
    <AdminTemplate title="Configurações">
      { configLoading &&
        <Spinner animation="border" />
      }
      { !configLoading &&
        <Form>
          <Form.Group>
            <Form.Label>Data de Começo das Votações</Form.Label>
            <Form.Control type="datetime-local" onChange={(e) => onDateChange(e.target.value, "start")} value={formatDate(votesStart)} />
          </Form.Group>
          <Form.Group>
            <Form.Label>Data de Fim das Votações</Form.Label>
            <Form.Control type="datetime-local" onChange={(e) => onDateChange(e.target.value, "end")} value={formatDate(votesEnd)} />
          </Form.Group>
          <Button disabled={configSaveLoading} onClick={onConfigSave}>
            { configSaveLoading &&
              <Spinner animation="border" />
            }
            { !configSaveLoading &&
              <>Salvar</>
            }
          </Button>
        </Form>
      }
    </AdminTemplate>
  );
}