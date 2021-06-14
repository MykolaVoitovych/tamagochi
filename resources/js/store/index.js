import Vue from 'vue'
import Vuex from 'vuex'
import {load, loadList} from '../api/pet.js'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null,
        petTypes: [],
        pets: [],
        settings: []
    },
    getters: {
        petTypes (state) {
            return state.petTypes
        },
        pets (state) {
            return state.pets
        },
        settings (state) {
            return state.settings
        }
    },
    mutations: {
        setUser: (state, user) => (state.user = user),
        setPetTypes: (state, petTypes) => (state.petTypes = petTypes),
        setPets: (state, pets) => (state.pets = pets),
        setSettings: (state, settings) => (state.settings = settings),
    },
    actions: {
        loadPets ({commit}) {
            loadList()
                .then(response => {
                    commit('setPets', response.data)
                })
                .catch(error => {
                    console.error(error)
                })
        }
    },
    strict: process.env.NODE_ENV !== 'production'
})
