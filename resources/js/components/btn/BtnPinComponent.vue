<template>
    <q-btn-component
        :tooltips="pin ? 'dejar de fijar' : 'fijar'"
        :icon="pin ? 'mdi-pin-off-outline' : 'mdi-pin-outline'"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnPinComponent",
});

const props = defineProps({
    pin: {
        type: Boolean,
        default: true,
    },
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
