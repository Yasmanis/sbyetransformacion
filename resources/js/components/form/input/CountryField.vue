<template>
    <select-field
        :label="label"
        :name="name"
        :model-value="modelValue"
        :others-props="{
            required: required,
            url_to_options: '/countries',
        }"
        @update="(name, val, full) => emits('update', name, val, full)"
    />
</template>

<script setup>
import SelectField from "./SelectField.vue";

defineOptions({
    name: "SelectField",
});

const props = defineProps({
    modelValue: Array | Number | Boolean | String,
    name: {
        type: String,
        default: "country_id",
    },
    label: {
        type: String,
        default: "pais",
    },
    required: Boolean,
});

const emits = defineEmits(["update"]);
</script>
