<template>
    <q-btn-component
        :color="color"
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive || color === 'white' ? 'white' : 'black'
        }-files-on-folder.png`"
        size="12px"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";
defineOptions({
    name: "BtnFilesFolderComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "informes",
    },
    color: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
