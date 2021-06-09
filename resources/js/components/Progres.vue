<template>
    <div class="row" style="align-items: center; justify-content: center; padding: 10px">
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
                    :aria-valuenow="value"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                </div>
            </div>
        </div>
        <div class="col-1">
            <button
                :class="progressClass"
                class="btn"
                @click="updateCharacteristic"
            >
                Add
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        value: {
            type: Number,
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
        }
    },
    computed: {
        progressStyle () {
            return `width: ${this.value}%`
        }
    },
    methods: {
        updateCharacteristic () {
            //
        }
    }
}
</script>

<style scoped>

</style>
