<template>
    <select-field
        :label="multiple ? 'tomos' : 'tomo'"
        name="book_volume"
        :modelValue="modelValue"
        :options="[
            {
                label: 'Tomo I',
                value: 'tomo_1',
            },
            {
                label: 'Tomo II',
                value: 'tomo_2',
            },
            {
                label: 'Tomo III',
                value: 'tomo_3',
            },
        ]"
        :othersProps="othersProps"
        :filterable="false"
        :multiple="multiple"
        @update="(prop, val) => emits('update', prop, val)"
    />
</template>

<script setup>
import SelectField from "../form/input/SelectField.vue";

defineOptions({
    model: "BookVolumeComponent",
});

defineProps({
    modelValue: String,
    othersProps: Object,
    multiple: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["update"]);
</script>
