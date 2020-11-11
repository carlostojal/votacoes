import { Bar, Pie } from "react-chartjs-2";
import Spinner from "react-bootstrap/Spinner";
import Button from "react-bootstrap/Button";
import Table from "react-bootstrap/Table";
import alertify from "alertifyjs";
import { useState, useEffect } from "react";

import AdminTemplate from "../Misc/AdminTemplate";

export default function Estatistica() {

  const [shouldLoadVotes, setShouldLoadVotes] = useState(true);
  const [votesData, setVotesData] = useState([]);
  const [votesByHour, setVotesByHour] = useState([]);
  const [votes, setVotes] = useState([]);
  const [sum, setSum] = useState(0);
  const [votosLoading, setVotosLoading] = useState(true);
  const [votosPorHoraLoading, setVotosPorHoraLoading] = useState(true);

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
                labels.push(lista.nome || "Votos brancos");
                
                let colour;
                if(!lista.nome)
                  colour = "rgb(255,255,255)";
                else
                  colour = `rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)})`;
                tempDataValues.push(lista.n_votos);
                colors.push(colour);
                tempSum += parseInt(lista.n_votos);
            });

            tempData = {
              title: "Nº de Votos por lista",
              labels: labels,
              datasets: [{
                data: tempDataValues,
                backgroundColor: colors
              }]
            };

            setVotesData(tempData);
            setSum(tempSum);
            
          } catch(e) {
            alertify.error("Ocorreu um erro ao obter os votos.");
          }

          setVotosLoading(false);
        });
        setShouldLoadVotes(false);
      }
  }, [shouldLoadVotes]);

  useEffect(() => {
    if(shouldLoadVotes) {
      fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/getVotesByHour.php`, {
        method: "POST",
        credentials: "include"
      })
        .then(res => res.json())
        .then((result) => {
          setVotosPorHoraLoading(false);

          let tempData = {};

          let labels = [];
          let tempDataValues = [];
          let colors = [];

          result.map((hora) => {
              labels.push(hora.hora+"h");
              
              const colour = `rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)})`;
              tempDataValues.push(hora.n_votos);
              colors.push(colour);
          });

          tempData = {
            labels: labels,
            datasets: [{
              data: tempDataValues,
              backgroundColor: colors
            }]
          };

          setVotesByHour(tempData);
        }, (error) => {
          alertify.error("Erro ao obter os votos por hora.");
        });
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
          <Pie data={votesData} />
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
                    <tr key={lista.id}>
                      <td>{lista.id || "N/A"}</td>
                      <td>{lista.nome || "Votos brancos"}</td>
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
                <td></td>
              </tr>
            </tbody>
          </Table>
          { votosPorHoraLoading &&
            <Spinner animation="border" />
          }
          { !votosPorHoraLoading &&
            <Bar data={votesByHour}/>
          }
        </>
      }
    </AdminTemplate>
  );
}