<template>
    <Layout title="privacidad">
        <div class="container q-pt-md">
            <div v-html="$page.props.config?.value"></div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";

defineOptions({
    name: "Private",
});
</script>
