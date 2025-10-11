<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-basket"
        :size="size"
        @click="onClick"
    >
        <slot></slot>
    </q-btn-component>
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnBasketComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "cesta",
    },
    size: {
        type: String,
        default: "lg",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
