<template>
    <q-btn-component
        :color="darkMode ? colorLight : colorDark"
        :icon="darkMode ? 'wb_sunny' : 'nights_stay'"
        :size="size"
        :tooltips="`${darkMode ? 'desactivar' : 'activar'} modo
        oscuro`"
        :tooltipsColor="darkMode ? 'primary-5' : colorDark"
        tooltipsAnchor="center left"
        tooltipsSelf="center right"
        flat
        @click="darkMode = !darkMode"
    />
</template>

<script setup>
import { watch, ref } from "vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";

defineOptions({
    name: "DarkSwitcher",
});

const props = defineProps({
    size: { type: String, default: "sm" },
    colorDark: { type: String, default: "black" },
    colorLight: { type: String, default: "yellow-6" },
});

const darkMode = ref(Dark.isActive);

watch(darkMode, (value) => {
    Dark.set(value);
});
</script>
