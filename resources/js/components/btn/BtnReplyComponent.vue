<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-reply-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnReplyComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "responder",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
