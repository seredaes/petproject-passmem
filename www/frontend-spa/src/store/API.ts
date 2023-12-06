import axios from "axios";

export default {
  registration(payload: { [key: string]: string }) {
    return axios.post("http://api.passmem.local/api/registration", payload);
  },
  auth(payload: { [key: string]: string }) {
    return axios.post("http://api.passmem.local/api/auth", payload);
  },
  ping() {
    return axios.post("http://api.passmem.local/api/ping");
  },
  getList() {
    return axios.post("http://api.passmem.local/api/list");
  },
  appendList(payload: { [key: string]: string }) {
    return axios.post("http://api.passmem.local/api/list/create", payload);
  },
  editList(payload: { [key: string]: string }) {
    return axios.post("http://api.passmem.local/api/list/update", payload);
  },
  deleteList(payload: { [key: string]: string }) {
    return axios.post("http://api.passmem.local/api/list/delete", payload);
  },
};
