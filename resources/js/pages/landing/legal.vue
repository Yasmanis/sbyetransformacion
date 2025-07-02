<template>
    <Layout title="avisos legales">
        <div class="container q-pt-md ck-editor">
            <div v-html="$page.props.config?.value"></div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";

defineOptions({
    name: "Legal",
});
</script>
