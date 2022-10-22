import axios from "axios";

class Api {
    constructor() {
        axios.defaults.baseURL = process.env.REACT_APP_API_URL;
    }
}

const api = new Api();

export default api;