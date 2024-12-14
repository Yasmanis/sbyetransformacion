<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-trash-can-outline"
        :size="size"
        :disable="disable"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnDeleteComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "eliminar",
    },
    flat: {
        type: Boolean,
        default: false,
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
