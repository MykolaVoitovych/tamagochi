<template>
    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <Progres
                key="1"
                title="голод"
                :value="10"
                type="food"
                progressClass="bg-success"
            />
            <Progres
                title="сон"
                :value="20"
                type="sleep"
                progressClass="bg-info"
            />
            <Progres
                title="забота"
                :value="30"
                type="care"
                progressClass="bg-warning"
            />
        </div>
    </div>
</template>

<script>
import Progres from '../components/Progres'

export default {
    components: {
        Progres
    },
}
</script>

<style scoped>

</style>
