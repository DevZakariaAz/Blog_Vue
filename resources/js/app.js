import "./bootstrap";
import Alpine from "alpinejs";
import { createApp } from "vue";
import router from "./router";
import { createPinia } from "pinia";

import App from "./App.vue";
import { useAuthStore } from "./stores/authStore";

window.Alpine = Alpine;
Alpine.start();

const app = createApp(App);

app.use(router);
app.use(createPinia());

const authStore = useAuthStore();
authStore.fetchUser(); // Fetch the authenticated user

app.mount("#app");
