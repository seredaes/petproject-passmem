import { createStore } from "vuex";
import Api from "./API";

export default createStore({
  state: {
    list: [],
    eventbus: {},
    auth: false,
  },
  getters: {
    resultList(state) {
      return state.list;
    },
    eventBusOn(state) {
      return state.eventbus;
    },
    getStatusAuth(state) {
      return state.auth;
    },
  },
  mutations: {
    mutateList(state, payload) {
      state.list = payload;
    },
    mutateEmit(state, payload) {
      state.eventbus = payload;
    },
    setStatusAuth(state, status: boolean) {
      state.auth = status;
    },
  },
  actions: {
    API_registration(context, payload) {
      return Api.registration(payload);
    },
    API_auth(context, payload) {
      return Api.auth(payload);
    },
    API_ping() {
      return Api.ping();
    },
    API_get_list() {
      return Api.getList();
    },
    API_append_list(context, payload: { [key: string]: string }) {
      return Api.appendList(payload);
    },
    API_edit_list(context, payload: { [key: string]: string }) {
      return Api.editList(payload);
    },
    API_delete_list(context, payload: { [key: string]: string }) {
      return Api.deleteList(payload);
    },
    eventBusCommit({ commit }, payload = {}) {
      commit("mutateEmit", payload);
    },
    setAuth({ commit }, status: boolean) {
      commit("setStatusAuth", status);
    },
  },
  modules: {},
});
