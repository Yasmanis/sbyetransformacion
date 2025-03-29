<template>
    <Layout title="tienda"> </Layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { useQuasar } from "quasar";
import { computed } from "vue";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

defineOptions({
    name: "ConsultaIndividual",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
</script>
<style scope>
.bg-mariposas {
    background-image: url("images/others/cambio-transformacion.png");
    background-repeat: no-repeat;
    background-size: 66%;
}
</style>
