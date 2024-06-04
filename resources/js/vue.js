import { createApp } from 'vue/dist/vue.esm-bundler.js'
import ElementPlus from 'element-plus'
import router from './routes/router'
import { i18nVue } from 'laravel-vue-i18n'
import Theme from './components/Theme.vue';

const app = createApp()

app.use(ElementPlus)
app.use(router)

app.component('theme', Theme)

app.use(i18nVue, {
    resolve: lang => {
        const langs = import.meta.glob('../../lang/*.json', { eager: true });

        return langs[`../../lang/${lang}.json`].default;
    },
})

app.mount('#app')
