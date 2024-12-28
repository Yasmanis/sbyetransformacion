<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-shape-square-rounded-plus"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnNoteComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "adicionar nota",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
