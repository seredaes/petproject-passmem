import { useNotification } from "@kyvg/vue3-notification";
const notification = useNotification();

export default {
  methods: {
    NotifyMixin(
      title: string,
      text: string,
      type: "error" | "success" | "warning",
      speed = 1000,
      duration = 1000
    ) {
      notification.notify({
        title: title,
        text: text,
        type: type,
        duration: duration,
        speed: speed,
      });
    },
  },
};
