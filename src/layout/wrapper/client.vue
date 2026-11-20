<template>
    <div class="main-layout">

        <TopCL />

        <main class="content">
            <router-view></router-view>
        </main>

        <FootedCL />

    </div>
</template>

<script>
import FootedCL from '../components/FootedCL.vue';
import TopCL from '../components/TopCL.vue';

export default {
    components: {
        TopCL,
        FootedCL
    }
}
</script>

<style scoped>

.main-layout{
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.content{
    flex: 1;
}

</style>