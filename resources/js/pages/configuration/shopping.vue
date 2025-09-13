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
                />
            </q-tabs>

            <q-tab-panels
                v-for="m in shoppingModules"
                :key="`tab-panel-module-${m.id}`"
                v-model="tab"
                animated
                swipeable
                vertical
                transition-prev="jump-up"
                transition-next="jump-up"
            >
                <q-tab-panel :name="`module-${m.id}`"> <list /> </q-tab-panel>
            </q-tab-panels>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import { onBeforeMount, ref } from "vue";
import { modules } from "../../services/current_module";
import List from "../../pages/products/list.vue";

defineOptions({
    name: "ShoppingModule",
});

const tab = ref(null);
const shoppingModules = ref([]);

onBeforeMount(() => {
    const storeModule = modules().find(
        (m) => m.base_url === "/admin/configuration/shopping"
    );
    shoppingModules.value = modules().filter(
        (m) => m.parent_id === storeModule.id
    );
});
</script>
