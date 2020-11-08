import Template from "../Misc/Template";

export default function NaoPermitido(props) {
  return (
    <Template title="Não permitido" description={props.location.cause} />
  );
}