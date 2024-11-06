<template>
    <Layout>
        <div class="q-pa-md q-gutter-sm">
            <editor-field name="legal" :model-value="legal" :saveBtn="true" @update="onUpdate" @save="onSave" />
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import EditorField from "../../components/form/input/EditorField.vue";
import { onBeforeMount, ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

defineOptions({
    name: "LegalPage",
});

const legal = ref('');

const onUpdate = (name, val) => {
    legal.value = val;
}

const onSave = (name, val) => {
    router.post('/admin/configuration/save', {
        keyName: 'legal',
        keyValue: legal.value
    });
}

onBeforeMount(() => {
    axios.get('/admin/configuration/index/legal').then((data) => {
        legal.value = data.data.value ?? '';
    }).catch(() => {

    });
});
</script>
