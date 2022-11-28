import axios from "axios";

const Api = axios.create({
  baseURL: "http://localhost/www/revistadev",
});

export default Api;