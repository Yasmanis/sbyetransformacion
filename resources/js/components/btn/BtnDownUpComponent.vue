<template>
    <q-btn-component
        :tooltips="up ? titleDown : titleUp"
        :icon="up ? iconDown : iconUp"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnDownUpComponent",
});

const props = defineProps({
    up: {
        type: Boolean,
        default: true,
    },
    iconUp: {
        type: String,
        default: "mdi-chevron-double-up",
    },
    iconDown: {
        type: String,
        default: "mdi-chevron-double-down",
    },
    titleUp: {
        type: String,
        default: "ocultar",
    },
    titleDown: {
        type: String,
        default: "mostrar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
