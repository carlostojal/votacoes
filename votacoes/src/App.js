import './App.css';
import {
  HashRouter as Router,
  Switch,
  Route,
} from "react-router-dom";
import "alertifyjs/build/css/alertify.css";

import Main from "./Components/Screens/Main";
import Listas from "./Components/Screens/Listas";
import Votar from "./Components/Screens/Votar";
import NaoPermitido from "./Components/Screens/NaoPermitido";
import Sobre from "./Components/Screens/Sobre";
import Admin from "./Components/Screens/Admin";
import Login from "./Components/Screens/Login";
import ListasAdmin from "./Components/Screens/ListasAdmin";

require("dotenv").config();

function App() {
  return (
    <Router>
      <Switch>
        <Route exact path="/" component={Main} />
        <Route exact path="/listas" component={Listas} />
        <Route exact path="/votar" component={Votar} />
        <Route exact path="/nao_permitido" component={NaoPermitido} />
        <Route exact path="/sobre" component={Sobre} />
        <Route exact path="/admin" component={Admin} />
        <Route exact path="/login" component={Login} />
        <Route exact path="/listas_admin" component={ListasAdmin} />
      </Switch>
    </Router>
  );
}

export default App;
