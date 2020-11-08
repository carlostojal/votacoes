import Table from "react-bootstrap/Table";
import Spinner from "react-bootstrap/Spinner";
import Button from "react-bootstrap/Button";
import alertify from "alertifyjs";
import { useEffect, useState } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function ListasAdmin() {

  const [listasLoading, setListasLoading] = useState(false);
  const [listas, setListas] = useState([]);
  const [listaDeleteLoading, setListaDeleteLoading] = useState(false);
  const [shouldLoadListas, setShouldLoadListas] = useState(true);
  
  // get lists when the boolean says it should
  useEffect(() => {
    if(shouldLoadListas) {
      setListasLoading(true);
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getListas.php`)
        .then(res => res.text())
        .then((result) => {
          setListasLoading(false);
          try {
            result = JSON.parse(result);
            console.log(result);
            setListas(result);
          } catch(e) {
            alertify.error("Ocorreu um erro.");
          }
          setListasLoading(false);
        }, (error) => {
          alertify.error("Ocorreu um erro ao carregar as listas. Verifique a sua ligação à internet.")
        });
        setShouldLoadListas(false);
      }
  }, [shouldLoadListas]);

  const onDelete = (lista_id) => {
    // ask user confirmation
    alertify.confirm("Eliminar Lista", "Tem a certeza que pretende eliminar a lista? A contagem de votos será perdida.", () => {

      setListaDeleteLoading(true);

      // create form with data
      const formData = new FormData();
      formData.append("id", lista_id);

      // make the request
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/deleteLista.php`, {
        method: "POST",
        credentials: "include",
        body: formData
      })
        .then(res => res.text())
        .then((result) => {

          setListaDeleteLoading(false);

          // show feedback using alert
          switch(result) {
            case "OK":
              alertify.success("Lista eliminada com sucesso.");
              setShouldLoadListas(true);
              break;
            default:
              alertify.error("Erro ao eliminar a lista.");
              break;
          }
        }, (error) => {
          alertify.error("Erro ao eliminar a lista. Verifique a sua ligação à internet.")
        });
    }, () => {

    });
  }

  return (
    <AdminTemplate title="Listas">
      <Button variant="primary">Adicionar Lista</Button>
      { listasLoading &&
        <Spinner animation="border" />
      }
      { !listasLoading &&
        <Table responsive>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            { 
              listas.map((lista) => {
                return (
                  <tr>
                    <td>{lista.id}</td>
                    <td>{lista.nome}</td>
                    <td>{lista.descricao}</td>
                    <td>
                      <Button variant="danger" onClick={() => onDelete(lista.id)}>Eliminar</Button>
                    </td>
                  </tr>
                );
              })
            }
          </tbody>
        </Table>
      }
    </AdminTemplate>
  );
}