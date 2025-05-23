<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-alert-outline"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnWarningComponent",
});

const props = defineProps({
    tooltips: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
