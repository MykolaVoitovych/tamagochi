<template>
    <div class="card">
        <div class="card-header">
            {{ pet.type }} {{ pet.name }}
        </div>
        <div class="card-body">
            <Progres
                key="1"
                title="голод"
                :value="pet.food"
                type="food"
                progressClass="bg-success"
            />
            <Progres
                title="сон"
                :value="pet.sleep"
                type="sleep"
                progressClass="bg-info"
            />
            <Progres
                title="забота"
                :value="pet.care"
                type="care"
                progressClass="bg-warning"
            />
        </div>
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
            if (pet) {
                return pet[0]
            }
        }
    }
}
</script>

<style scoped>

</style>
