<template>
    <q-btn-component
        :tooltips="public ? titleHide : titlePublic"
        :icon="public ? 'mdi-backspace-outline' : 'mdi-location-enter'"
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
        default: "publicar",
    },
    titleHide: {
        type: String,
        default: "despublicar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
