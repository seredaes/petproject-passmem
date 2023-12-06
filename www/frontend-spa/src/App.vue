<template>
  <HeaderComponent v-if="getStatusAuth" />
  <router-view />
  <notifications position="top right" />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import HeaderComponent from "@/components/HeaderComponent.vue";
import { mapActions, mapGetters } from "vuex";

export default defineComponent({
  name: "App",
  components: { HeaderComponent },
  computed: {
    ...mapGetters(["getStatusAuth"]),
  },
  methods: {
    ...mapActions(["setAuth"]),
  },
  created() {
    if (localStorage.getItem("access_token")) {
      this.setAuth(true);
    } else {
      this.setAuth(false);
    }
  },
});
</script>

<style lang="scss"></style>
