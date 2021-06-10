<template>
    <div class="card w-75 m-auto">
        <div class="card-body">
            <h5 class="card-title">Create pet</h5>
            <form>
                <div class="form-group row mb-2">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            v-model="form.name"
                        >
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="selectType" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select
                            id="selectType"
                            class="form-control"
                            v-model="form.type"
                        >
                            <option
                                v-for="type in petTypes"
                                :value="type.value"
                            >
                                {{ type.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" @click.prevent="createPet">Create</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            form: {
                name: '',
                type: ''
            },
            petTypes: []
        }
    },
    created () {
        this.petTypes = this.$store.state.petTypes
    },
    methods: {
        createPet () {
            let url = route('pets.store')
            axios.post(url, this.form).then(response => {
                this.$router.push({ name: 'pets'})
            }).catch(e => {
                console.error(e)
            })
        }
    }
}
</script>

<style scoped>

</style>
