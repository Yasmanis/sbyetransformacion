<template>
    <Layout>
        <div class="q-pa-md q-gutter-sm">
            <editor-field name="private" :model-value="config" :saveBtn="true" @update="onUpdate" @save="onSave" />
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
    name: "PrivatePage",
});

const config = ref('');

const onUpdate = (name, val) => {
    config.value = val;
}

const onSave = (name, val) => {
    router.post('/admin/configuration/save', {
        keyName: 'private',
        keyValue: config.value
    });
}

onBeforeMount(() => {
    axios.get('/admin/configuration/index/private').then((data) => {
        config.value = data.data.value ?? '';
    }).catch(() => {

    });
});
</script>
