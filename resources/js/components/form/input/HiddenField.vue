<template></template>

<script setup>
import { onMounted } from "vue";

defineOptions({
    name: "HiddenField",
});

const props = defineProps({
    modelValue: String | Number,
    name: {
        type: String,
        required: true,
    },
});

const emits = defineEmits(["update"]);

onMounted(() => {
    emits("update", props.name, props.modelValue);
});
</script>
