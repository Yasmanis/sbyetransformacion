<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-play-circle-outline"
        :size="size"
        :flat="flat"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnPlayComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "reproducir",
    },
    flat: {
        type: Boolean,
        default: false,
    },
    size: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
