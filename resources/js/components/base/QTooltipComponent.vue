<template>
    <q-tooltip
        :class="props.class"
        :anchor="anchor"
        :self="self"
        :offset="offset"
        style="font-size: 12px"
        v-if="props.title"
    >
        {{ props.title }}</q-tooltip
    >
</template>

<script setup>
defineOptions({
    name: "QTooltipComponent",
});

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    class: { type: String, default: "bg-dark" },
    anchor: {
        type: String,
        default: "top middle",
    },
    self: {
        type: String,
        default: "bottom middle",
    },
    offset: {
        type: Array,
        default: () => [5, 5],
    },
});
</script>

<style lang="scss" scoped></style>
