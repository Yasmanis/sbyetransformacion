<template>
    <q-btn-component
        :tooltips="title ? title : leftDirection ? 'anterior' : 'siguiente'"
        :icon="leftDirection ? iconLeft : iconRight"
        :disable="disable"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnLeftRightComponent",
});

const props = defineProps({
    leftDirection: {
        type: Boolean,
        default: true,
    },
    iconLeft: {
        type: String,
        default: "mdi-chevron-double-left",
    },
    iconRight: {
        type: String,
        default: "mdi-chevron-double-right",
    },
    title: String,
    disable: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
