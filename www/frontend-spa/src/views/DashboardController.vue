<template>
  <div class="dashboard-wrapper">
    <div
      class="popup-wrapper"
      v-if="popup_visible"
      @click.self="popup_visible = !popup_visible"
    >
      <div class="popup-append">
        <form @submit.prevent>
          <label for="title" class="wrapper-field">
            Заголовок (обязательное поле):
            <input
              type="text"
              class="input-text-element"
              id="title"
              name="title"
              autocomplete="off"
              v-model="userForm.title"
            />
            <div
              class="error_block"
              v-if="validation_errors.hasOwnProperty('title')"
            >
              <span v-for="item in validation_errors['title']" :key="item"
                >- {{ item }}</span
              >
            </div>
          </label>
          <label for="login" class="wrapper-field">
            Login (email | username):
            <input
              type="text"
              class="input-text-element"
              id="login"
              name="login"
              autocomplete="off"
              v-model="userForm.login"
            />
            <div
              class="error_block"
              v-if="validation_errors.hasOwnProperty('login')"
            >
              <span v-for="item in validation_errors['login']" :key="item"
                >- {{ item }}</span
              >
            </div>
          </label>
          <div class="d-flex flex-x-right flex-y-center">
            <label for="password" class="wrapper-field">
              Пароль:
              <input
                type="text"
                class="input-text-element"
                id="password"
                name="password"
                autocomplete="off"
                v-model="userForm.password"
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
            <button class="btn btn-warning ml-2" @click.self="generatePassword">
              Генерировать
            </button>
          </div>
          <label for="login" class="wrapper-field">
            Описание (опционально):
            <textarea
              class="input-textarea-element"
              id="description"
              name="description"
              autocomplete="off"
              v-model="userForm.description"
            ></textarea>
            <div
              class="error_block"
              v-if="validation_errors.hasOwnProperty('description')"
            >
              <span v-for="item in validation_errors['description']" :key="item"
                >- {{ item }}</span
              >
            </div>
          </label>

          <div class="d-flex flex-y-center flex-x-right">
            <button
              class="btn btn-danger"
              v-if="popup_mode === 'add'"
              @click="makeRecord"
            >
              Добавить
            </button>
            <button
              class="btn btn-danger"
              v-if="popup_mode === 'edit'"
              @click="makeEdit"
            >
              Редактировать
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="dashboard-block">
      <div class="d-flex flex-x-right flex-y-center">
        <button class="btn btn-success" @click="appendItem">
          Добавить запись
        </button>
      </div>

      {{}}

      <div v-if="Object.keys(resultList).length === 0" class="dashboardItem">
        <div class="item-header">
          <p>Ни одной записи еще не добавлено...</p>
        </div>
      </div>

      <DashboardItem
        v-for="item in resultList"
        :key="item.id"
        :data="item"
        :visible="visible"
      >
        <template #header>
          <div
            class="item-header"
            :class="{ active: visible.includes(item.id) }"
            @click="makeVisible(item.id)"
          >
            .:: {{ item.title }}
          </div>
        </template>

        <template #footer>
          <div class="item-footer" v-if="visible.includes(item.id)">
            <button class="btn btn-warning mr-2" @click="editItem(item)">
              Редактировать
            </button>
            <button class="btn btn-danger" @click="deleteItem(item.id)">
              Удалить
            </button>
          </div>
        </template>
      </DashboardItem>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import DashboardItem from "@/components/DashboardItem.vue";
import { mapActions, mapGetters, mapMutations } from "vuex";
import ValidationClass from "@/ValidationClass/ValidationClass";
import NotifyMixin from "@/mixins/NotifyMixin";
import { State } from "@/types/DashboardControllerTypes";

export default defineComponent({
  name: "DashboardView",
  mixins: [NotifyMixin],
  components: { DashboardItem },
  computed: {
    ...mapGetters(["resultList"]),
  },
  data(): State {
    return {
      userForm: {
        title: "",
        login: "",
        password: "",
        description: "",
        id: "",
      },
      validation_errors: {},
      popup_visible: false,
      visible: [],
      popup_mode: "add",
    };
  },
  methods: {
    ...mapActions([
      "API_get_list",
      "API_append_list",
      "eventBusCommit",
      "API_delete_list",
      "API_edit_list",
    ]),
    ...mapMutations(["mutateList"]),
    randomize(values: Array<string>): Array<string> {
      let index: number = values.length,
        randomIndex: number;

      // While there remain elements to shuffle.
      while (index != 0) {
        // Pick a remaining element.
        randomIndex = Math.floor(Math.random() * index);
        index--;

        // And swap it with the current element.
        [values[index], values[randomIndex]] = [
          values[randomIndex],
          values[index],
        ];
      }

      return values;
    },
    generatePassword() {
      const string =
        "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_{}[]?";
      const password = this.randomize(string.split(""));
      let result = [];
      for (let i = 0; i < 16; i++) {
        result.push(password[i]);
      }
      this.userForm.password = result.join("");
    },
    makeRecord() {
      const validationClass = new ValidationClass(this.userForm, [
        { title: "required|min:2|max:150" },
        { login: "required|min:2|max:150" },
        { password: "required|min:8|max:64" },
      ]);

      this.validation_errors = validationClass.makeValidation();

      if (validationClass.check()) {
        this.API_append_list(this.userForm)
          .then(() => {
            this.userForm = {
              title: "",
              login: "",
              password: "",
              description: "",
              id: "",
            };
            this.getList();
            this.popup_visible = false;
            this.visible = [];
            this.NotifyMixin("Успешно", "Запись успешно добавлена", "success");
          })
          .catch(() => {
            return true;
          });
      }
    },
    makeEdit() {
      const validationClass = new ValidationClass(this.userForm, [
        { title: "required|min:2|max:150" },
        { login: "required|min:2|max:150" },
        { password: "required|min:8|max:64" },
      ]);

      this.validation_errors = validationClass.makeValidation();

      if (validationClass.check()) {
        this.API_edit_list(this.userForm)
          .then(() => {
            this.userForm = {
              title: "",
              login: "",
              password: "",
              description: "",
              id: "",
            };
            this.getList();
            this.popup_visible = false;
            this.visible = [];
            this.NotifyMixin("Успешно", "Запись успешно изменена", "success");
          })
          .catch(() => {
            return true;
          });
      }
    },
    getList() {
      this.API_get_list().then((response) => {
        this.mutateList(response?.data?.data ?? []);
      });
    },
    makeVisible(id: string) {
      if (this.visible.includes(id)) {
        this.visible = this.visible.filter((item) => item !== id);
      } else {
        this.visible.push(id);
      }
    },
    deleteItem(id: string) {
      if (window.confirm("Точно удалить?")) {
        this.API_delete_list({
          id: id,
        })
          .then(() => {
            this.getList();
          })
          .catch(() => {
            return true;
          });
      }
    },
    editItem(item: {
      title: string;
      login: string;
      password: string;
      description: string;
      id: string;
    }) {
      this.userForm = {
        title: item.title,
        login: item.login,
        password: item.password,
        id: item.id,
        description: item.description,
      };
      this.popup_visible = true;
      this.popup_mode = "edit";
    },
    appendItem() {
      // # custom EventBus
      this.eventBusCommit({
        name: "showAlert",
        payload: {},
      });

      this.userForm = {
        title: "",
        login: "",
        password: "",
        id: "",
        description: "",
      };
      this.popup_visible = true;
      this.popup_mode = "add";
    },
  },
  created() {
    this.getList();
  },
});
</script>
