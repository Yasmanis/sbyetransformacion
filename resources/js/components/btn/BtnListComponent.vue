<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="list ? 'mdi-format-list-bulleted' : 'mdi-menu'"
        @click="onClick"
        ><slot></slot
    ></q-btn-component>
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnListComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "",
    },
    list: Boolean,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
