import { useEffect } from "react";

export default function SessionChecker(props) {
  
  useEffect(() => {
    fetch(`${process.env.REACT_APP_BACKEND_ADDRESS}/api/isLogged.php`)
      .then(res => res.text())
      .then((result) => {
        let returnVal;
        result == "TRUE" ? returnVal = true : returnVal = false;
        props.onCheck(returnVal);
      });
  }, []);

  return null;
}