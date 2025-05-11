<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-credit-card-sync-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnReturnSaleComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "gestionar devolucion",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
