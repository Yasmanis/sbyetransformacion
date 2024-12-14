<template>
    <q-btn-component
        :tooltips="full ? 'restaurar' : 'maximizar'"
        :icon="full ? 'fullscreen_exit' : 'fullscreen'"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnFullScreenComponent",
});

const props = defineProps({
    full: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
