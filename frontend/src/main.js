import './assets/main.css'
import { createApp } from 'vue'
import router from './router'
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import App from './App.vue'
import core from './plugins/core';
import { createPinia } from 'pinia';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(core);

app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.mount('#app');
