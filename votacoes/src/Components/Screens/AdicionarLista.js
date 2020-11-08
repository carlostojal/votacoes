import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import { useHistory } from "react-router-dom";
import alertify from "alertifyjs";
import { useState } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function AdicionarLista() {

  const [adicionarLoading, setAdicionarLoading] = useState(false);
  const [nome, setNome] = useState(null);
  const [descricao, setDescricao] = useState(null);

  const history = useHistory();

  const onChange = (value, type) => {
    switch(type) {
      case "nome":
        setNome(value);
        break;
      case "descricao":
        setDescricao(value);
        break;
      default:
        setNome(null);
        setDescricao(null);
        break;
    }
  }

  const onAdicionar = () => {

    alertify.confirm("Adicionar Lista", `
    Tem a certeza que pretende adicionar a lista?<br><br>
    <b>Nome:</b><br>
    ${nome}<br><br>
    <b>Descrição</b><br>
    ${descricao}`, () => {
      setAdicionarLoading(true);

      const formData = new FormData();
      formData.append("name", nome);
      formData.append("description", descricao);
  
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/addLista.php`, {
        method: "POST",
        credentials: "include",
        body: formData
      })
        .then(res => res.text())
        .then((result) => {
  
          setAdicionarLoading(false);
  
          switch(result) {
            case "OK":
              alertify.success("Lista adicionada com sucesso.");
              history.push("/listas_admin");
              break;
            default:
              alertify.error("Erro ao adicionar a lista.");
              break;
          }
        }, (error) => {
          alertify.error("Erro ao adicionar a lista. Verifique a sua ligação à internet.");
        });
    }, () => {

    });
  }

  return (
    <AdminTemplate title="Adicionar Lista">
      <Form>
        <Form.Group>
          <Form.Label>Nome</Form.Label>
          <Form.Control type="text" onChange={(e) => onChange(e.target.value, "nome")} />
        </Form.Group>
        <Form.Group>
          <Form.Label>Descrição</Form.Label>
          <Form.Control as="textarea" rows={4} onChange={(e) => onChange(e.target.value, "descricao")} />
        </Form.Group>
        <Button onClick={onAdicionar} disabled={adicionarLoading}>
          { adicionarLoading &&
            <Spinner animation="border" />
          }
          { !adicionarLoading &&
            <>Adicionar</>
          }
        </Button>
      </Form>
    </AdminTemplate>
  );
}