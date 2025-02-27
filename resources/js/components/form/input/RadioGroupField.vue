<template>
    <label for="" v-if="label">{{ label }}</label>
    <q-option-group
        type="radio"
        v-model="model"
        :options="options"
        :left-label="leftLabel"
        :inline="inline"
        :dense="dense"
        @update:model-value="onUpdate"
    />
</template>
<script setup>
import { ref, onMounted } from "vue";

defineOptions({
    name: "RadioGroupField",
});

const props = defineProps({
    modelValue: String | Number | Boolean,
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        default: "",
    },
    leftLabel: {
        type: Boolean,
        default: false,
    },
    inline: {
        type: Boolean,
        default: false,
    },
    dense: {
        type: Boolean,
        default: false,
    },
    options: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const emits = defineEmits(["update"]);

const model = ref(null);

onMounted(() => {
    model.value = props.modelValue;
});

const onUpdate = (val) => {
    emits("update", props.name, val);
};
</script>
