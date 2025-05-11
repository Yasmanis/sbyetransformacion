<template>
    <q-btn-component :tooltips="tooltips" icon="mdi-heart" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnHeartComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "quitar de mis deseos",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
