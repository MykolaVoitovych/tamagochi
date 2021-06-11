<template>
    <div class="row d-flex justify-content-center align-items-center p-2">
        <div class="col-1">
            {{ title }}
        </div>
        <div class="col-8">
            <div class="progress">
                <div
                    class="progress-bar"
                    :class="progressClass"
                    role="progressbar"
                    :style="progressStyle"
                    :aria-valuenow="pet[type]"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    {{ pet[type] }}
                </div>
            </div>
        </div>
        <div class="col-1">
            <button
                class="btn"
                :class="progressClass"
                :disabled="!canUpdate"
                @click="updateAttribute"
            >
                Add
            </button>
        </div>
    </div>
</template>

<script>
import {update} from '../api/pet'
import {mapActions} from 'vuex'

export default {
    props: {
        title: {
            type: String,
            required: true
        },
        pet: {
            type: Object,
            required: true
        },
        progressClass: {
            type: String,
            required: false,
            default: 'bg-success'
        },
        type: {
            type: String,
            required: true
        },
        canUpdate: {
            type: Boolean,
            required: false,
            default: true
        }
    },
    computed: {
        progressStyle () {
            return `width: ${this.pet[this.type]}%`
        }
    },
    methods: {
        ...mapActions(['loadPets']),
        updateAttribute () {
            update(this.pet.id, {attribute: this.type})
                .then(response => {
                    this.loadPets()
                });
        }
    }
}
</script>

<style scoped>

</style>
