import Vue from 'vue';
import moment from "moment";
import App from './domain/components/App.vue';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

moment.locale('ru');

Vue.config.productionTip = false;

Vue.use(IconsPlugin);
Vue.use(BootstrapVue);

new Vue({render: h => h(App)}).$mount('#app');