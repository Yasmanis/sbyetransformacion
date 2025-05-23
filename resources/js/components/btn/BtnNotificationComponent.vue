<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-notification.png`"
        :size="size"
        @click="onClick"
        ><q-badge
            floating
            style="margin-top: -6px; margin-right: -4px"
            v-if="badge"
            >{{ badge }}</q-badge
        ></q-btn-component
    >
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
        default: "12px",
    },
    badge: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
