<template>
  <q-toolbar>
    <q-icon :name="icon" :size="iconSize"></q-icon>
    <q-toolbar-title style="padding-left: 5px">{{ title }}</q-toolbar-title>
    <q-btn flat round dense icon="close" v-close-popup />
  </q-toolbar>
  <q-separator />
</template>

<script setup>
defineOptions({
  name: "DialogHeaderComponent",
});

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  icon: {
    type: String,
  },
  iconSize: {
    type: String,
    default: "25px",
  },
  closable: {
    type: Boolean,
    defaul: true,
  },
});
</script>
