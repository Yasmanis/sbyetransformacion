<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-cart-variant"
        :size="size"
        :disable="disable"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnShoppinCarComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "seguir comprando",
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
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
