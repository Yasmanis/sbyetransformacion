<template>
    <q-btn-component
        :tooltips="lock ? titleUnlock : titleLock"
        :icon="lock ? iconUnlock : iconLock"
        flat
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnLockUnlockComponent",
});

const props = defineProps({
    lock: {
        type: Boolean,
        default: true,
    },
    iconLock: {
        type: String,
        default: "mdi-lock-outline",
    },
    iconUnlock: {
        type: String,
        default: "mdi-lock-open-variant-outline",
    },
    titleLock: {
        type: String,
        default: "bloquear",
    },
    titleUnlock: {
        type: String,
        default: "desbloquear",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
