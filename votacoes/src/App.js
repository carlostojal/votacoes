import './App.css';
import {
  HashRouter as Router,
  Switch,
  Route,
} from "react-router-dom";
import Main from "./Components/Screens/Main";
import Listas from "./Components/Screens/Listas";

function App() {
  return (
    <Router>
      <Switch>
        <Route exact path="/" component={Main} />
        <Route exact path="/listas" component={Listas} />
      </Switch>
    </Router>
  );
}

export default App;
