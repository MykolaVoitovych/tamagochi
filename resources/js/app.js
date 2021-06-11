require('./bootstrap');
require('alpinejs');

import Vue from "vue";
import store from './store'
import router from './router.js'
import Base from './Base.vue';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

let app
if (document.getElementById('app')) {
    let appElement = document.getElementById('app')

    store.commit('setUser', JSON.parse(appElement.dataset.user))
    store.commit('setPetTypes', JSON.parse(appElement.dataset.petTypes))
    store.commit('setPets', JSON.parse(appElement.dataset.pets))

    app = new Vue({
        router,
        store,
        render: h => h(Base),
        created() {
            window.Echo.channel('my-channel').listen(".event", response => {
                if (response.userId === store.state.user.id) {
                    store.dispatch('loadPets')
                }
            });
        }
    }).$mount('#app')
}

export default app
