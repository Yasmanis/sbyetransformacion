<template>
    <q-btn-component
        :tooltips="tooltips"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-highlight.png`"
        :size="size"
        :disable="items.length === 0"
        @click="onClick"
    />
</template>

<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { Dark } from "quasar";

defineOptions({
    name: "HighlightComponent",
});

const props = defineProps({
    items: {
        type: Array,
        default: [],
    },
    tooltips: {
        type: String,
        default: "resaltar",
    },
    state: {
        type: Boolean,
        default: true,
    },
    module: {
        type: Object,
        required: true,
    },
    size: String,
});

const onClick = () => {
    let { model, singular_label } = props.module;
    const send = useForm({
        highlights: props.items.map((m) => m.id),
        state: props.state,
        label: singular_label,
        model,
    });
    send.post("/utils/highlight");
};
</script>
