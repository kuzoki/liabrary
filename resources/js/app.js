require('./bootstrap');


import Vue from 'vue';


import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './router';
import App from './main/app'


const vue = new Vue({
    el: '#myapp',
    components: { App },
    router: new VueRouter(routes)
});