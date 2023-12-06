import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./assets/scss/app.scss";
import axios from "axios";
import VueAxios from "vue-axios";
import Notifications from "@kyvg/vue3-notification";
import GLOBAL_CONST from "@/const/GLOBAL_CONST";

const app = createApp(App);

app.config.globalProperties.$globalConst = GLOBAL_CONST;
app
  .use(store)
  .use(router)
  .use(Notifications)
  .use(VueAxios, axios)
  .mount("#app");

axios.interceptors.request.use((config) => {
  config.timeout = 2000;
  config.baseURL = GLOBAL_CONST.API_URL as string;
  config.headers.Authorization =
    localStorage.getItem("access_token") === null
      ? ""
      : "Bearer " + localStorage.getItem("access_token");
  config.headers.Accept = "application/json; charset=utf-8";
  return config;
});

axios.interceptors.response.use(
  function (response) {
    return response;
  },
  function (error) {
    if (error.code === "ERR_NETWORK") {
      app.config.globalProperties.$notify({
        title: "Ошибка API",
        text: "Сервер API недоступен! Обратитесь к владельцу или проверьте свое сетевое подключение.",
        type: "error",
        duration: 8000,
        speed: 1000,
      });
      localStorage.clear();
      router.push({ name: "HomeController" });
      return Promise.reject(error);
    }

    // check status code
    switch (+error.response.status) {
      case 422:
        app.config.globalProperties.$notify({
          title: "Ошибка валидации",
          text: error?.response?.data?.message ?? "Ошибка валидации на сервере",
          type: "error",
          duration: 3000,
          speed: 1000,
        });
        break;
      case 401:
        localStorage.clear();
        if (app.config.globalProperties.$route.name !== "home") {
          app.config.globalProperties.$notify({
            title: "Ошибка авторизации",
            text: "Авторизируйтесь или убедитесь, что ваш аккаунт активен",
            type: "error",
            duration: 3000,
            speed: 1000,
          });
          app.config.globalProperties.$router.push({ name: "HomeController" });
        }
        break;
      default:
        break;
    }

    return Promise.reject(error);
  }
);
