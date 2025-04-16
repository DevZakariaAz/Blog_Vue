import "./bootstrap";
import "../css/app.css"; 

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import { useAuthStore } from "./stores/auth";

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);

const authStore = useAuthStore();

authStore.fetchUser().then(() => {
    app.mount("#app");
});
