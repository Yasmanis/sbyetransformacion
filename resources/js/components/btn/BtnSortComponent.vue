<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-sort" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnSortComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "ordenar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
