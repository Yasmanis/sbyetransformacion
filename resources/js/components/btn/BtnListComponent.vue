<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-format-list-bulleted"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnListComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
