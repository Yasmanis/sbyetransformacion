<template>
    <q-btn-component
        :tooltips="public ? titleHide : titlePublic"
        :icon="public ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnPublicComponent",
});

const props = defineProps({
    public: {
        type: Boolean,
        default: true,
    },
    titlePublic: {
        type: String,
        default: "mostrar al publico",
    },
    titleHide: {
        type: String,
        default: "ocultar al publico",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
