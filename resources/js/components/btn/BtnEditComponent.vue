<template>
    <q-btn-component
        :disable="disable"
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive || color === 'white' ? 'white' : 'black'
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
    color: String,
    disable: Boolean,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
