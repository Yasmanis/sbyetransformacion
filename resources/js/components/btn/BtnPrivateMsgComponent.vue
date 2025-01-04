<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-message-text-lock-outline"
        @click="onClick"
        ><slot></slot
    ></q-btn-component>
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnPrivateMsgComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "mensajes privados",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
