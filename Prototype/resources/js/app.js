import { createApp } from 'vue';
import App from './App.vue';
import i18n from './i18n/translations'; // Import the i18n configuration

const app = createApp(App);

app.use(i18n); // Use i18n globally
app.mount('#app');
