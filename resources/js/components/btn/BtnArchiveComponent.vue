<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-folder-text-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnArchiveComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "archivar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
