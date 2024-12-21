<template>
    <q-btn-component :tooltips="tooltips" :icon="`img:${$page.props.public_path}images/icon/${Dark.isActive?'white':'black'}-notification.png`" :size="size" @click="onClick" />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";
defineOptions({
    name: "BtnNotificationComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "gestion de avisos",
    },
    size: {
        type: String,
        default: '12px'
    }
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
