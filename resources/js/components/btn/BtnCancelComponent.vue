<template>
    <q-btn-component
        :tooltips="cancel ? 'cancelar' : 'cerrar'"
        icon="mdi-cancel"
        :size="size"
        class="fa-rotate-90"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnCancelComponent",
});

const props = defineProps({
    cancel: {
        type: Boolean,
        default: false,
    },
    flat: {
        type: Boolean,
        default: false,
    },
    size: String,
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
