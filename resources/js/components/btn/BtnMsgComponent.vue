<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-message-processing-outline"
        @click="onClick"
        ><slot></slot
    ></q-btn-component>
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnMsgComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "mensajes",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
