<template>

</template>

<script>
    import NProgress from 'nprogress/nprogress.js';
    import 'nprogress/nprogress.css';
    export default {

        mounted() {
            NProgress.start();
            NProgress.done();
        }
    }
</script>

<style scoped>

</style>
