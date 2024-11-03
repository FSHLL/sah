import { createApp } from 'vue/dist/vue.esm-bundler.js'
import PrimeVue from 'primevue/config';
import router from './routes/router'
import { i18nVue } from 'laravel-vue-i18n'
import Theme from './components/Theme.vue'
import Aura from './presets/aura'
import Message from 'primevue/message';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Toast from 'primevue/toast';
import { createPinia } from 'pinia';

const app = createApp()
const pinia = createPinia()

app.use(router)
app.use(i18nVue, {
    resolve: lang => {
        const langs = import.meta.glob('../../lang/*.json', { eager: true });

        return langs[`../../lang/${lang}.json`].default;
    },
})
app.use(PrimeVue, {
    unstyled: true,
    pt: Aura
});
app.use(ToastService)
app.use(ConfirmationService)
app.use(pinia)

app.component('theme', Theme)
app.component('message', Message)
app.component('toast', Toast)

app.mount('#app')
