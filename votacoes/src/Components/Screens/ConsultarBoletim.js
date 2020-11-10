import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";
import alertify from "alertifyjs";
import { useState } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function ConsultarBoletim() {

  const [loading, setLoading] = useState(false);
  const [email, setEmail] = useState(null);

  const onEmailChange = (value) => {
    setEmail(value);
  }

  const onConsult = () => {

    const formData = new FormData();
    formData.append("email", email);

    setLoading(true);
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/consultBoletim.php`, {
      method: "POST",
      credentials: "include",
      body: formData
    })
      .then(res => res.text())
      .then((result) => {

        setLoading(false);

        try {
          result = JSON.parse(result);

          alertify.alert("Consultar Boletim", `
            <b>Nº de Boletim</b><br>
            ${result.cod}<br><br>
            <b>Código de Confirmação</b><br>
            ${result.cod_confirmacao}<br><br>
            <b>Usado</b><br>
            ${result.usado ? "Sim" : "Não"}
          `);
        } catch(e) {
          switch(result) {
            case "EMAIL_DOES_NOT_EXIST":
              alertify.warning("Não foi registado um boletim para este email.");
              break;
            default:
              alertify.error("Ocorreu um erro ao consultar o boletim");
              break;
          }
        }

      }, (error) => {
        alertify.error("Ocorreu um erro ao consultar o boletim. Verifique a sua ligação à internet.")
      });
  }

  return (
    <AdminTemplate title="Consultar Boletim">
      <Form>
        <Form.Group>
          <Form.Label>Email</Form.Label>
          <Form.Control type="email" onChange={(e) => onEmailChange(e.target.value)} />
        </Form.Group>
        <Button disabled={loading} onClick={onConsult}>
          { loading &&
            <Spinner animation="border" />
          }
          { !loading &&
            <>Consultar</>
          }
        </Button>
      </Form>
    </AdminTemplate>
  );
}