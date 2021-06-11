<template>
    <div class="card w-75 m-auto">
        <div class="card-body">
            <h5 class="card-title">Create pet</h5>
            <form>
                <div class="form-group row mb-2">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input
                            id="name"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': errors.name && errors.name.length
                            }"
                            v-model="form.name"
                        >
                        <div
                            v-if="errors.name && errors.name.length"
                            class="invalid-feedback"
                        >
                            <div v-for="error in errors.name" :key="error.key">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="selectType" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select
                            id="selectType"
                            class="form-control"
                            :class="{
                                'is-invalid': errors.type && errors.type.length
                            }"
                            v-model="form.type"
                        >
                            <option
                                v-for="type in availablePetTypes"
                                :value="type.value"
                            >
                                {{ type.title}}
                            </option>
                        </select>
                        <div
                            v-if="errors.type && errors.type.length"
                            class="invalid-feedback"
                        >
                            <div v-for="error in errors.type" :key="error.key">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" @click.prevent="createPet">Create</button>
            </form>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    data () {
        return {
            form: {
                name: '',
                type: ''
            },
            errors: []
        }
    },
    computed: {
        ...mapGetters([
            'pets',
            'petTypes'
        ]),
        availablePetTypes () {
            let notAvailablePetTypes = this.pets.map(pet => pet.type)
            return this.petTypes.filter(petType => !notAvailablePetTypes.includes(petType.value))
        }
    },
    methods: {
        createPet () {
            let url = route('pets.store')
            axios.post(url, this.form).then(response => {
                this.$router.push({ name: 'pets'})
            }).catch(error => {
                let errorStatus = error.response ? error.response.status : null
                if ((errorStatus == 422) && error.response && error.response.data) {
                    this.errors = error.response.data.errors
                }
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
