<template>
    <Head>
        <title>Aviso legal | Sbye Transformación</title>
        <meta name="robots" content="noindex, follow" />
    </Head>
    <Layout title="avisos legales">
        <div class="container q-pt-md ck-editor">
            <div v-html="$page.props.config?.value"></div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({
    name: "Legal",
});
</script>
