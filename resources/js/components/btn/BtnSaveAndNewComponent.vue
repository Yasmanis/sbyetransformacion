<template>
    <q-btn-component
        tooltips="guardar y adicionar otro"
        icon="mdi-checkbox-marked-circle-plus-outline"
        :size="size"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnSaveAndNewComponent",
});

const props = defineProps({
    size: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
