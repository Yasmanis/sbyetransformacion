<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-sort"
        :disable="disable"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnSortComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "ordenar",
    },
    disable: Boolean,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
