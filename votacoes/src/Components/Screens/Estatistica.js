import { Pie } from "react-chartjs-2";
import Spinner from "react-bootstrap/Spinner";
import Button from "react-bootstrap/Button";
import Table from "react-bootstrap/Table";
import alertify from "alertifyjs";
import { useState, useEffect } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function Estatistica() {

  const [shouldLoadVotes, setShouldLoadVotes] = useState(true);
  const [data, setData] = useState([]);
  const [votes, setVotes] = useState([]);
  const [sum, setSum] = useState(0);
  const [votosLoading, setVotosLoading] = useState(true);

  useEffect(() => {
    if(shouldLoadVotes) {
      setVotosLoading(true);
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getVotes.php`, {
        credentials: "include"
      })
        .then(res => res.text())
        .then((result) => {

          try {
            result = JSON.parse(result);
            
            setVotes(result);

            let tempData = {};

            let labels = [];
            let tempDataValues = [];
            let colors = [];
            let tempSum = 0;

            result.map((lista) => {
                labels.push(lista.nome);
                tempDataValues.push(lista.n_votos);
                colors.push(`rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)})`)
                tempSum += parseInt(lista.n_votos);
            });

            tempData = {
              labels: labels,
              datasets: [{
                data: tempDataValues,
                backgroundColor: colors
              }]
            };

            setData(tempData);
            setSum(tempSum);
            
          } catch(e) {
            alertify.error("Ocorreu um erro ao obter os votos.");
          }

          setVotosLoading(false);
        });
        setShouldLoadVotes(false);
      }
  }, [shouldLoadVotes]);

  return (
    <AdminTemplate title="Estatística">
      { votosLoading &&
        <Spinner animation="border" />
      }
      { !votosLoading &&
        <>
          <Button onClick={() => setShouldLoadVotes(true)}>Recarregar</Button>
          <Pie data={data} />
          <Table responsive>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nº de Votos</th>
                <th>% de Votos</th>
              </tr>
            </thead>
            <tbody>
              {
                votes.map((lista) => {
                  return (
                    <tr>
                      <td>{lista.id}</td>
                      <td>{lista.nome}</td>
                      <td>{lista.n_votos}</td>
                      <td><b>{((lista.n_votos / sum) * 100).toFixed(2)}%</b></td>
                    </tr>
                  );
                })
              }
              <tr>
                <td></td>
                <td></td>
                <td>{sum}</td>
              </tr>
            </tbody>
          </Table>
        </>
      }
    </AdminTemplate>
  );
}