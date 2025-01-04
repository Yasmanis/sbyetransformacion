<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-share-variant-outline"
        @click="onClick"
        ><slot></slot
    ></q-btn-component>
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnShareComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "compartir",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
