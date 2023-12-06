<template>
  <div class="error-block">404 - page not found</div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "HomeView",
  components: {},
});
</script>

<style lang="scss" scoped>
@import "@/assets/scss/_variables.scss";
.error-block {
  width: 400px;
  height: auto;
  background: $base-color-dark;
  padding: 15px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  border-radius: 0 10px 10px 10px;
  color: #fff;
  font-size: 2em;

  &:before {
    content: "Error";
    display: block;
    width: 120px;
    height: 30px;
    background: $base-color-dark;
    position: absolute;
    left: 0;
    top: -30px;
    border-radius: 5px 5px 0 0;
    font-size: 0.6em;
    line-height: 27px;
    font-weight: bold;
    color: red;
  }

  &:after {
    content: "";
    position: absolute;
    left: 90px;
    top: -27px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 30px 30px 30px;
    border-color: transparent transparent #353a37 transparent;
    transform: rotate(0deg);
  }
}
</style>
