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
require("dotenv").config();

function App() {
  return (
    <Router>
      <Switch>
        <Route exact path="/" component={Main} />
        <Route exact path="/listas" component={Listas} />
        <Route exact path="/votar" component={Votar} />
      </Switch>
    </Router>
  );
}

export default App;
