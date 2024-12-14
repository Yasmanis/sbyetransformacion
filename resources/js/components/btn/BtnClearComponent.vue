<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-eraser" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnClearComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "limpiar todo",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
