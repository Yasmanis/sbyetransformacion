<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-plus" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnAddComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "adicionar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
