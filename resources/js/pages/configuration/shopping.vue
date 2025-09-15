<template>
    <Layout> </Layout>
</template>

<script setup>
import Layout from "../../layouts/ShoppingLayout.vue";
import { onBeforeMount, ref } from "vue";
import { modules } from "../../services/current_module";
import List from "../../pages/products/list.vue";

defineOptions({
    name: "ShoppingModule",
});
</script>
