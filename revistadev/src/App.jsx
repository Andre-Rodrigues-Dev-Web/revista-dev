import React, { useEffect, useState } from "react";
const App = () => {
  const [data, setData] = useState([]);

  const getPost = async () => {
    fetch("http://localhost/www/revistadev/artigos.php")
      .then((response) => response.json())
      .then((responseJson) => (
        //console.log(responseJson),
        setData(responseJson.records)
      ));
  }
  useEffect(() => {
    getPost();
  }, [])
  return (
    <div>
      <h1>Artigos</h1>
      {
        //retorna os dados do data
        Object.values(data).map(artigo => (
          <div key={artigo.id}>
            <h2>{artigo.titulo}</h2>
            <p>{artigo.texto}</p>
          </div>
        ))
      }    
    </div>
  );
}

export default App;
