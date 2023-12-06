<template>
  <form @submit.prevent class="registration-block">
    <label for="name" class="wrapper-field">
      Ваше имя:
      <input
        type="text"
        class="input-text-element"
        id="name"
        v-model="userForm.name"
        name="name"
        autocomplete="off"
      />
      <div class="error_block" v-if="validation_errors.hasOwnProperty('name')">
        <span v-for="item in validation_errors['name']" :key="item">
          - {{ item }}</span
        >
      </div>
    </label>
    <label for="email" class="wrapper-field">
      Email адрес:
      <input
        type="text"
        class="input-text-element"
        id="email"
        v-model="userForm.email"
        name="email"
        autocomplete="off"
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
        v-model="userForm.password"
        class="input-text-element"
        autocomplete="off"
      />
      <div
        class="error_block"
        v-if="validation_errors.hasOwnProperty('password')"
      >
        <span v-for="item in validation_errors['password']" :key="item"
          >- {{ item }}</span
        >
      </div>
    </label>
    <label for="password_confirmation" class="wrapper-field">
      Повторите пароль:
      <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        class="input-text-element"
        v-model="userForm.password_confirmation"
        autocomplete="off"
      />
      <div
        class="error_block"
        v-if="validation_errors.hasOwnProperty('password_confirmation')"
      >
        <span
          v-for="item in validation_errors['password_confirmation']"
          :key="item"
          >- {{ item }}</span
        >
      </div>
    </label>

    <div class="d-flex flex-x-right flex-y-center">
      <button class="btn btn-danger" @click="makeRegistration">
        Регистрация
      </button>
    </div>

    <p class="info mt-4">
      Если уже зарегистрированы,
      <router-link :to="{ name: 'HomeController' }">Вам сюда</router-link>
    </p>
  </form>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { State } from "@/types/RegistrationControllerTypes";
import ValidationClass from "@/ValidationClass/ValidationClass";
import { mapActions } from "vuex";
import NotifyMixin from "@/mixins/NotifyMixin";

export default defineComponent({
  name: "RegistrationController",
  mixins: [NotifyMixin],
  data(): State {
    return {
      userForm: {
        email: "",
        password: "",
        password_confirmation: "",
        name: "",
      },
      validation_errors: {},
    };
  },
  methods: {
    ...mapActions(["API_registration"]),
    makeRegistration() {
      const validationClass = new ValidationClass(this.userForm, [
        { name: "required|min:5|max:50" },
        { email: "required|min:1|max:50|email" },
        { password: "required|min:8|max:32" },
        { password_confirmation: "required|min:8|max:32|same:password" },
      ]);

      this.validation_errors = validationClass.makeValidation();

      if (validationClass.check()) {
        this.API_registration(this.userForm)
          .then((response) => {
            this.NotifyMixin(
              "Успешно зарегистрированы",
              response.data.message,
              "success"
            );
          })
          .catch(() => {
            return true;
          });
      }
    },
  },
});
</script>
