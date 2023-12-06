<template>
  <form @submit.prevent class="login-block">
    <label for="login" class="wrapper-field">
      Email адрес:
      <input
        type="email"
        class="input-text-element"
        id="login"
        name="login"
        autocomplete="off"
        v-model="userForm.email"
      />
      <div class="error_block" v-if="validation_errors.hasOwnProperty('email')">
        <span v-for="item in validation_errors['email']" :key="item"
          >- {{ item }}</span
        >
      </div>
    </label>

    <label for="password" class="wrapper-field">
      Пароль:
      <input
        type="password"
        id="password"
        name="password"
        class="input-text-element"
        autocomplete="off"
        v-model="userForm.password"
      />
      <div
        class="error_block"
        v-if="validation_errors.hasOwnProperty('password')"
      >
        <span v-for="item in validation_errors['password']" :key="item"
          >- {{ item }}
        </span>
      </div>
    </label>

    <div class="d-flex flex-x-right flex-y-center">
      <button class="btn btn-danger" @click="makeAuth">Войти</button>
    </div>

    <p class="info">
      <a href="/registration">Регистрация</a>
      в системе
    </p>
  </form>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ValidationClass from "@/ValidationClass/ValidationClass";
import { mapActions } from "vuex";
import { State } from "@/types/HomeControllerTypes";
import NotifyMixin from "@/mixins/NotifyMixin";

export default defineComponent({
  name: "HomeController",
  mixins: [NotifyMixin],
  components: {},
  data(): State {
    return {
      userForm: {
        email: "",
        password: "",
      },
      validation_errors: {},
    };
  },
  methods: {
    ...mapActions(["API_auth", "setAuth"]),
    makeAuth() {
      const validationClass = new ValidationClass(this.userForm, [
        { email: "required|min:1|max:50|email" },
        { password: "required|min:8|max:32" },
      ]);

      this.validation_errors = validationClass.makeValidation();

      if (validationClass.check()) {
        this.API_auth(this.userForm)
          .then((response) => {
            const access_token = response.data.data.access_token;
            const name = response.data.data.name;
            this.NotifyMixin(
              "Успешно",
              `${name} Вы успешно авторизировались!`,
              "success"
            );

            localStorage.setItem("access_token", access_token);
            this.setAuth(true);
            this.$router.push({ name: "DashboardController" });
          })
          .catch(() => {
            return true;
          });
      }
    },
  },
  created() {
    if (localStorage.getItem("access_token")) {
      this.$router.push({ name: "DashboardController" });
    }

    // # Global Constants
    // # console.log(this.$globalConst);
    // # console.log(this.$globalConst["API_URL"]);
  },
});
</script>
