<template>
    <q-toolbar>
        <q-icon :name="icon" :size="iconSize"></q-icon>
        <q-toolbar-title style="padding-left: 5px">{{ title }}</q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup />
    </q-toolbar>
    <q-separator v-if="separator" />
</template>

<script setup>
defineOptions({
    name: "DialogHeaderComponent",
});

const props = defineProps({
    separator: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
    },
    iconSize: {
        type: String,
        default: "20px",
    },
    closable: {
        type: Boolean,
        defaul: true,
    },
});
</script>
