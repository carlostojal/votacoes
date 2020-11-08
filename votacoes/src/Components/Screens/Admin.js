import AdminTemplate from "../Misc/AdminTemplate";

export default function Admin() {

  return (
    <AdminTemplate title="Área administrativa">
      <p>Esta é a área que permite administrar o processo eleitoral.</p>
      <p>Na barra de navegação lateral encontra-se o menu de opções administrativas.</p>
      <p>Segue-se uma breve explicação das mesmas:</p>
      <ul>
        <li>
          <b>Listas:</b> Aqui criam-se e eliminam-se as listas candidatas.
        </li>
        <li>
          <b>Estatística:</b> Aqui encontram-se as estatísticas das votações.
        </li>
        <li>
          <b>Configurações:</b> Aqui configura-se a data e hora de começo e fim das votações, assim como se as estatísticas deverão ficar publicamente visíveis no fim das mesmas.
        </li>
      </ul>
    </AdminTemplate>
  );
}