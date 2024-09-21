<template>
    <q-btn
        :color="color"
        :round="round"
        :size="size"
        :icon="icon"
        :flat="flat"
        :no-caps="no_caps"
        :disable="disable"
        :outline="outline"
        :rounded="rounded"
        :square="square"
        :dense="dense"
        :align="align"
        :padding="padding"
        :text-color="text_color"
        :label="label"
        :class="props.class"
        :loading="loading"
        @click="onClick"
    >
        <q-tooltip-component
            :title="tooltips"
            :self="tooltipsSelf"
            :anchor="tooltipsAnchor"
            :offset="tooltipsOffset"
            v-if="tooltips"
            :class="`bg-${tooltipsColor ? tooltipsColor : color}`"
        />
        <slot></slot>
    </q-btn>
</template>

<script setup>
import QTooltipComponent from "./QTooltipComponent.vue";
defineOptions({
    name: "QBtnComponent",
});

const props = defineProps({
    tooltips: String,
    tooltipsColor: String,
    tooltipsAnchor: {
        type: String,
        defaul: "bottom middle",
    },
    tooltipsSelf: {
        type: String,
        defaul: "top middle",
    },
    tooltipsOffset: {
        type: Array,
        default: () => [5, 5],
    },
    class: String,
    label: String,
    round: {
        type: Boolean,
        default: true,
    },
    flat: {
        type: Boolean,
        default: false,
    },
    no_caps: {
        type: Boolean,
        default: false,
    },
    disable: {
        type: Boolean,
        default: false,
    },
    outline: {
        type: Boolean,
        default: false,
    },
    rounded: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    square: {
        type: Boolean,
        default: false,
    },
    dense: {
        type: Boolean,
        default: false,
    },
    align: {
        type: String,
        default: "center",
    },
    padding: String,
    color: { type: String, default: "primary" },
    text_color: String,
    icon: String,
    size: {
        type: String,
        default: "sm",
    },
});

const emits = defineEmits(["click"]);

const onClick = () => {
    emits("click");
};
</script>
