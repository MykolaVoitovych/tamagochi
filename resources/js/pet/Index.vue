<template>
    <div>
        <div
            v-if="pets.length"
            class="row"
        >
            <div
                v-for="pet in pets"
                class="col-sm-3"
            >
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ pet.name }}</h5>
                        <p class="card-text">{{ pet.type }}</p>
                        <a href="#" class="btn btn-primary" @click.prevent="showPet(pet.id)">Show</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center" v-else>
            <p>You don't have pets. But you can <router-link :to="{ name: 'pets.create' }">Create Pet</router-link></p>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    computed: {
        ...mapGetters([
            'pets'
        ])
    },
    methods: {
        showPet (id) {
            this.$router.push({ name: 'pets.show', params: { id: id }})
        }
    }
}
</script>

<style scoped>

</style>
