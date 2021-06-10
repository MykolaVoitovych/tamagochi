import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from './pet/Index'
import Show from './pet/Show'
import Create from './pet/Create'

Vue.use(VueRouter)

let router =  new VueRouter({
    routes: [
        {
            path: '/',
            name: 'pets',
            component: Index,
        },
        {
            path: '/create',
            name: 'pets.create',
            component: Create
        },
        {
            path: '/:id',
            component: Show,
            name: 'pets.show'
        }
    ],
    linkExactActiveClass: 'is-active'
})

export default router
