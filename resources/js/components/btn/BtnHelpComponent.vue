<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-help-circle-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnHelpComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "ayuda",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
