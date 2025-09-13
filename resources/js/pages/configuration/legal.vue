<template>
    <Layout>
        <q-page padding>
            <q-tabs
                v-model="tab"
                no-caps
                inline-label
                align="left"
                class="text-white"
                @update:model-value="onUpdateTab"
            >
                <q-tab name="legal" icon="mdi-gavel" label="aviso legal" />
                <q-tab
                    name="private"
                    icon="mdi-shield-account"
                    label="privacidad"
                />
                <q-tab
                    name="conditions"
                    icon="mdi-file-document-outline"
                    label="condiciones de contratacion"
                />
            </q-tabs>
            <editor-field
                name="legal"
                :model-value="legal"
                :saveBtn="true"
                height="500px"
                @update="onUpdate"
                @save="onSave"
            />
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import EditorField from "../../components/form/input/EditorField.vue";
import { onBeforeMount, onMounted, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { Screen } from "quasar";

defineOptions({
    name: "LegalPage",
});

const tab = ref("legal");
const legal = ref("");
const page = usePage();

const onUpdate = (name, val) => {
    legal.value = val;
};

const onSave = (name, val) => {
    router.post("/admin/configuration/save", {
        keyName: tab.value,
        keyValue: legal.value,
    });
};

onMounted(() => {});

onBeforeMount(() => {
    onUpdateTab(tab.value);
});

const onUpdateTab = (t) => {
    const config = page.props.config;
    if (config) {
        legal.value = config.find((c) => c.key === t)?.value || "";
    }
};
</script>
