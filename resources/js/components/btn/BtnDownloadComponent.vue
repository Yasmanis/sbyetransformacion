<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-download.png`"
        @click="onClick"
    />
</template>

<script setup>
import { Dark } from "quasar";
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnDownloadComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "descargar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
