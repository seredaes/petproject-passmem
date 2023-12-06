import { useNotification } from "@kyvg/vue3-notification";
const notification = useNotification();
import { AxiosError } from "axios";

export default {
  methods: {
    errorHandler(error: AxiosError) {
      debugger;
      if (error.code !== "ERR_NETWORK") {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        const msg = error?.response?.data?.message ?? "Ошибка запроса";
        notification.notify({
          title: `Ошибка`,
          text: msg,
          type: "error",
          duration: 1000,
          speed: 1000,
        });
      }
    },
  },
};
