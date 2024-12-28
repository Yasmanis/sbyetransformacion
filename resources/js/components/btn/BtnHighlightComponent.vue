<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-highlight.png`"
        :size="size"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";

defineOptions({
    name: "BtnHighlightComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "resaltar",
    },
    size: {
        type: String,
        default: "10px",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
