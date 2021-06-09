require('./bootstrap');
require('alpinejs');

import Vue from "vue";
import store from './store'
import Base from './Base.vue';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

let app
if (document.getElementById('app')) {
    let appElement = document.getElementById('app')

    store.commit('setUser', JSON.parse(appElement.dataset.user))

    app = new Vue({
        store,
        render: h => h(Base)
    }).$mount('#app')
}

export default app
