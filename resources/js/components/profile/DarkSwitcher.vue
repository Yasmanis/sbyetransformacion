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
        @click="changeTheme"
    />
</template>

<script setup>
import { watch, ref } from "vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import { Dark } from "quasar";
import { useForm } from "@inertiajs/vue3";

defineOptions({
    name: "DarkSwitcher",
});

const props = defineProps({
    size: { type: String, default: "sm" },
    colorDark: { type: String, default: "black" },
    colorLight: { type: String, default: "yellow-6" },
});

const darkMode = ref(Dark.isActive);

const changeTheme = () => {
    const dark = !darkMode.value;
    useForm({
        dark: dark,
    }).post("/admin/users/change-theme", {
        onSuccess: () => {
            Dark.set(dark);
            darkMode.value = dark;
        },
    });
};
</script>
