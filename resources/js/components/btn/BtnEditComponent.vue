<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-edit.png`"
        size="12px"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";
defineOptions({
    name: "BtnEditComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "editar",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
