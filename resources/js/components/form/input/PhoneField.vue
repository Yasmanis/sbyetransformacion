<template>
    <text-field
        :name="phoneName"
        :model-value="phoneValue"
        :others-props="{
            required: required,
        }"
        :disable="disable"
        @update="(name, val, full) => emits('update', name, val, full)"
    >
        <template #before>
            <select-field
                :name="codeName"
                :label="label"
                :model-value="codeValue"
                :disable="disable"
                :options="codes"
                :filterable="false"
                :clearable="false"
                style="width: 120px !important"
                @update="(name, val, full) => emits('update', name, val, full)"
                :others-props="{
                    required: required,
                }"
            />
        </template>
    </text-field>
</template>

<script setup>
import SelectField from "./SelectField.vue";
import TextField from "./TextField.vue";

defineOptions({
    name: "PhoneField",
});

const props = defineProps({
    phoneName: {
        type: String,
        default: "phone",
    },
    codeName: {
        type: String,
        default: "code",
    },
    label: {
        type: String,
        default: "telefono",
    },
    required: Boolean,
    phoneValue: String,
    codeValue: String,
    disable: {
        type: Boolean,
        default: true,
    },
    codes: {
        type: Array,
        default: [],
    },
});

const emits = defineEmits(["update"]);
</script>
