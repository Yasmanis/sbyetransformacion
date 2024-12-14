<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-cog-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnConfComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "configurar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
