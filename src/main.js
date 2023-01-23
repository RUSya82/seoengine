// import Vue from 'vue'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import BootstrapVue3 from 'bootstrap-vue-3'

// Импортируйте файлы CSS Bootstrap и BootstrapVue (порядок важен)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

// import '@/assets/css/bootstrap.min.scss';
import '@/assets/css/style.scss';
// Сделайте BootstrapVue доступным для всего проекта
// Vue.use(BootstrapVue)
// При желании установите плагин компонентов иконок BootstrapVue
// Vue.use(IconsPlugin)

const app = createApp(App);
app.use(store);
app.use(router);
app.use(BootstrapVue3);
app.mount('#app');
//.use(store).use(router).mount('#app')