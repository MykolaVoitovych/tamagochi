<template>
    <ul class="nav justify-content-end mb-5">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <router-link
                    :to="{ name: 'pets' }"
                >
                    My pets
                </router-link></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <router-link
                    :to="{ name: 'pets.create' }"
                >
                    Create pet
                </router-link>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" @click.prevent="logout">Lgout</a>
        </li>
    </ul>
</template>

<script>
export default {
    methods: {
        logout () {
            axios.post(route('logout')).then(response => {
                if (response.data.success) {
                    document.location.href = response.data.redirect_url
                }
            }).catch(e => {
                console.error(e)
            })
        }
    }
}
</script>

<style scoped>

</style>
