<template>
    <q-btn-component
        :tooltips="tooltips"
        :size="size"
        icon="mdi-paperclip"
        class="rotate-180"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnAttachmentComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "adjuntos",
    },
    size: {
        type: String,
        default: "md",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
