<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="icon"
        :size="size"
        :disable="disable"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnUserCardComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "ver ficha",
    },
    flat: {
        type: Boolean,
        default: true,
    },
    disable: {
        type: Boolean,
        default: false,
    },
    size: String,
    icon: {
        type: String,
        default: "mdi-card-account-details-outline",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
