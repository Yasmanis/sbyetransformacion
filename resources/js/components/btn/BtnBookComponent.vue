<template>
    <q-btn-component
        tooltips="libros"
        icon="mdi-book-open-page-variant-outline"
        :disabled="disabled"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";

defineOptions({
    name: "BtnSaveComponent",
});

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
