<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-basket" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnNoteComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "cesta",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
