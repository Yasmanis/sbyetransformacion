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
    name: "BtnShowHideComponent",
});

const props = defineProps({
    public: {
        type: Boolean,
        default: true,
    },
    titlePublic: {
        type: String,
        default: "mostrar",
    },
    titleHide: {
        type: String,
        default: "ocultar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
