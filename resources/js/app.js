import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { OhVueIcon, addIcons } from 'oh-vue-icons';
import * as FaIcons from 'oh-vue-icons/icons/fa';
import * as GiIcons from 'oh-vue-icons/icons/gi';
import * as IoIcons from 'oh-vue-icons/icons/io';
import * as MdIcons from 'oh-vue-icons/icons/md';
import piniaPluginPersistedState from 'pinia-plugin-persistedstate';
import App from './App.vue';
import router from './router/router';

const app = createApp(App);
const pinia = createPinia();
const Fa = Object.values({ ...FaIcons });
const Gi = Object.values({ ...GiIcons });
const Io = Object.values({ ...IoIcons });
const Md = Object.values({ ...MdIcons });

addIcons(...Fa);
addIcons(...Gi);
addIcons(...Io);
addIcons(...Md);

pinia.use(piniaPluginPersistedState);

app.use(router);
app.use(pinia);
app.component('v-icon', OhVueIcon);
app.mount('#app');