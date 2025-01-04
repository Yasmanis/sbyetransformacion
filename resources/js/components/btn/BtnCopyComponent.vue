<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-content-copy"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnCopyComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "copiar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
