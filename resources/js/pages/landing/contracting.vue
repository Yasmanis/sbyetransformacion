<template>
    <Head>
        <title>Condiciones de contratación | Sbye Transformación</title>
        <meta name="robots" content="noindex, follow" />
    </Head>
    <Layout title="condiciones de contratacion">
        <div class="container q-pt-md">
            <div v-html="$page.props.config?.value"></div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({
    name: "Contracting",
});
</script>
