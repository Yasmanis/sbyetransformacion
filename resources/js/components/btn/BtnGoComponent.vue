<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-arrow-right-thin-circle-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnGoComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "ir",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
