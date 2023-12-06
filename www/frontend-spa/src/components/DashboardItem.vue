<template>
  <div class="dashboardItem">
    <slot name="header"></slot>
    <div class="item-body" v-if="visible.includes(data.id)">
      <div class="double-panel">
        <div class="block-credential">
          <p class="title">Login</p>
          <p class="content">
            {{ data.login }}
            <img
              src="/images/copy_icon_2.png"
              class="copy"
              @click="copy('login')"
            />
          </p>
        </div>
        <div class="block-credential">
          <p class="title">Password</p>
          <p class="content" @click="showShortPassword = !showShortPassword">
            <template v-if="showShortPassword">
              {{ shortPassword }}
            </template>
            <template v-if="!showShortPassword">
              {{ data.password }}
            </template>
            <img
              src="/images/copy_icon_2.png"
              class="copy"
              @click.stop="copy('password')"
            />
          </p>
        </div>
      </div>
      <div class="block-credential">
        <p class="title">Описание:</p>
        <pre class="pre">{{ data.description }}</pre>
      </div>
    </div>
    <slot name="footer"></slot>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { mapGetters } from "vuex";
import NotifyMixin from "@/mixins/NotifyMixin";

export default defineComponent({
  name: "DashboardItem",
  mixins: [NotifyMixin],
  props: {
    data: {
      type: Object as PropType<{
        id: string;
        title: string;
        login: string;
        password: string;
        description: string;
      }>,
      required: true,
    },
    visible: {
      type: Array as PropType<Array<string>>,
      required: true,
    },
  },
  computed: {
    ...mapGetters(["eventBusOn"]),
    shortPassword() {
      return this.data.password.slice(0, 3) + "**********";
    },
  },
  data() {
    return {
      showShortPassword: true,
    };
  },
  watch: {
    eventBusOn: function (value: object) {
      const result = JSON.parse(JSON.stringify(value));
      if (result.name === "showAlert") {
        // console.log("Globalevent works");
      }
    },
  },
  methods: {
    copyLoginSuccess() {
      this.NotifyMixin("Скопировано", "Ваш логин скопирован", "success");
    },
    copyLoginError() {
      this.NotifyMixin(
        "Ошибка копирования",
        "К сожалению, копирование в вашем браузере не работает, сделайте это самостоятельно",
        "error"
      );
    },
    copyPasswordSuccess() {
      this.NotifyMixin("Скопировано", "Ваш пароль скопирован", "success");
    },
    copyPasswordError() {
      this.NotifyMixin(
        "Ошибка копирования",
        "К сожалению, копирование в вашем браузере не работает, сделайте это самостоятельно",
        "error"
      );
    },
    copy(mode: string) {
      if (mode === "login") {
        const textArea = document.createElement("textarea");
        textArea.value = this.data.login;

        textArea.style.top = "-2000px";
        textArea.style.left = "-2000px";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
          const successful = document.execCommand("copy");
          if (successful) {
            this.copyLoginSuccess();
          } else {
            this.copyLoginError();
          }
        } catch (err) {
          this.copyLoginError();
        }
        document.body.removeChild(textArea);
        // end copy login
      } else if (mode === "password") {
        const textArea = document.createElement("textarea");
        textArea.value = this.data.password;

        textArea.style.top = "-2000px";
        textArea.style.left = "-2000px";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
          const successful = document.execCommand("copy");
          if (successful) {
            this.copyPasswordSuccess();
          } else {
            this.copyPasswordError();
          }
        } catch (err) {
          this.copyPasswordError();
        }
        document.body.removeChild(textArea);
        // end copy login
      }
    },
  },
  created() {
    // # watcher for custom EventBus
    // this.$watch("eventBusOn", (newValue) => {
    //   debugger;
    //   const result = JSON.parse(JSON.stringify(newValue));
    //   if (result.name === "showAlert") {
    //     console.log("Globalevent");
    //   }
    // });
  },
});
</script>

<style lang="scss" scoped></style>
