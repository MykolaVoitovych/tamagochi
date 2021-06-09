<template>
    <main>
        <Header />

        <div class="container">
            <div class="c-app-layout__inner">
                <Show></Show>
<!--                <router-view />-->
            </div>
        </div>
    </main>
</template>

<script>
import Header from "./particals/Header";
import Show from './pet/Show'

export default {
    components: {
        Header,
        Show
    },
    props: ['data'],
}
</script>
