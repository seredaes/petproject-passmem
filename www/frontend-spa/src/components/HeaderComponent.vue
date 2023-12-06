<template>
  <div class="header-block">
    <button class="btn btn-danger" @click.self="exit">Выйти</button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { mapActions } from "vuex";

export default defineComponent({
  name: "HeaderComponent",
  methods: {
    ...mapActions(["setAuth"]),
    exit() {
      localStorage.clear();
      this.setAuth(false);
      window.location.href = "/";
    },
  },
});
</script>

<style scoped></style>
