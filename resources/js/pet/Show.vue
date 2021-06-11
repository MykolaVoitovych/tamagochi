<template>
    <div class="card">
        <div class="card-header">
            {{ pet.type }} {{ pet.name }}
        </div>
        <div class="card-body">
            <Progres
                title="голод"
                :pet="pet"
                :can-update="canUpdate('food', 5)"
                type="food"
                progressClass="bg-success"
            />
            <Progres
                title="сон"
                :pet="pet"
                :can-update="canUpdate('sleep', 10)"
                type="sleep"
                progressClass="bg-info"
            />
            <Progres
                title="забота"
                :pet="pet"
                :can-update="canUpdate('care', 1)"
                type="care"
                progressClass="bg-warning"
            />
        </div>
    </div>
</template>

<script>
import Progres from '../components/Progres'
import {mapGetters} from 'vuex'
import moment from 'moment'

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
        },
    },
    methods: {
        canUpdate (attribute, minutes) {
            if (this.pet[attribute] < 100) {
                let lastUpdate = moment(this.pet[`${attribute}_at`]).add(minutes, 'm')
                return moment().isAfter(lastUpdate)
            }
            return false
        }
    }
}
</script>

<style scoped>

</style>
