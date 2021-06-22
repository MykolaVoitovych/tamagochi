<template>
    <div
        v-if="!pet.is_died"
        class="card"
    >
        <div class="card-header">
            {{ pet.type }} {{ pet.name }}
        </div>
        <div class="card-body">
            <Progres
                v-for="attribute in pet.attributes"
                :key="attribute.id"
                :attribute="attribute"
                :pet="pet"
                progressClass="bg-success"
            />
        </div>
    </div>
    <div v-else class="d-flex justify-content-center">
        {{ pet.type }}&nbsp;<strong>{{ pet.name }}</strong>&nbsp;died 😭😭😭
    </div>
</template>

<script>
import Progres from '../components/Progres'
import {mapGetters} from 'vuex'

export default {
    components: {
        Progres
    },
    computed: {
        ...mapGetters(['pets']),
        pet () {
            let pet = this.pets.filter(pet => pet.id == this.$route.params.id)
            if (pet && Array.isArray(pet)) {
                return pet[0]
            }
        },
    }
}
</script>

<style scoped>

</style>
