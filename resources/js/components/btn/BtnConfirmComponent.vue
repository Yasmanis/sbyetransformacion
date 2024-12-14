<template>
    <q-btn-component :tooltips="tooltips" :icon="icon" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnConfirmComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "confirmar",
    },
    icon: {
        type: String,
        default: "mdi-checkbox-marked-circle-outline",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
