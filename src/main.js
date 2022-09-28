import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import '@/assets/css/bootstrap.min.scss';
import '@/assets/css/style.scss';

createApp(App).use(store).use(router).mount('#app')
