<template>
    <Layout>
        <q-page padding>
            <q-tabs
                v-model="tab"
                no-caps
                inline-label
                align="left"
                class="text-white"
            >
                <q-tab
                    v-for="m in shoppingModules"
                    :key="`tab-module-${m.id}`"
                    :name="`module-${m.id}`"
                    :icon="m.ico"
                    :label="m.plural_label"
                    @click="router.get(m.base_url)"
                />
            </q-tabs>

            <q-page-container class="shopping-container">
                <slot />
            </q-page-container>
        </q-page>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import Layout from "./AdminLayout.vue";
import {
    getActiveModule,
    getChildrenFromParent,
    getModuleFromUrl,
} from "../services/current_module";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "ShoppingLayout",
});

const tab = ref(null);
const shoppingModules = ref([]);

onBeforeMount(() => {
    const storeModule = getModuleFromUrl("/admin/configuration/shopping");
    shoppingModules.value = getChildrenFromParent(storeModule);

    const active = getActiveModule();
    if (active) {
        tab.value = `module-${active.id}`;
    }
});
</script>

<style scoped>
.shopping-container {
    padding: 0px !important;
    margin-top: 2px;
}
</style>
