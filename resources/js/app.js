import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { VueReCaptcha } from "vue-recaptcha-v3";

const app = createApp(App);

app.use(router);
app.use(VueReCaptcha, {
    siteKey: import.meta.env.VITE_RECAPTCHA_SITE_KEY,
    loaderOptions: {
        autoHideBadge: true
    }
});
app.mount('#app');
