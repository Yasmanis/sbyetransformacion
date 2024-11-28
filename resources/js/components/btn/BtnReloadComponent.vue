<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-reload" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnReloadComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "actualizar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
