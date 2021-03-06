import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
import * as Vue from "vue"; // in Vue 3
import axios from "axios";
import VueAxios from "vue-axios";

import "./index.css";

const app = createApp(App);

import DefaultLayout from "./layouts/defaultLayout.vue";
import VueLayout from "./layouts/vueLayout.vue";

app.component("default-layout", DefaultLayout);
app.component("vue-layout", VueLayout);

import Echo from "laravel-echo";

import Pusher from "pusher-js";

window.Echo = new Echo({
  broadcaster: "pusher",
  key: "local", // .env
  wsHost: window.location.hostname,
  // namespace: 'App\\Events',
  wsPort: 6005,
  forceTLS: false,
  disableStats: true,
  enabledTransports: ["ws"],
});

app.use(createPinia());
app.use(router);
app.use(VueAxios, axios);

app.mount("#app");
