<template>
    <q-btn-component
        :tooltips="tooltips"
        icon="mdi-calendar-plus"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineOptions({
    name: "BtnCalendarPlusComponent",
});

const props = defineProps({
    tooltips: {
        type: String,
        default: "gestionar evento",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
