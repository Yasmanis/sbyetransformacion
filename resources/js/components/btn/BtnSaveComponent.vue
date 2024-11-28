<template>
    <q-btn-component
        tooltips="guardar"
        icon="mdi-content-save-outline"
        :size="size"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnSaveComponent",
});

const props = defineProps({
    size: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
