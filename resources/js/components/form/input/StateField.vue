<template>
    <select-field
        :name="country?.name ?? 'country_id'"
        :label="country?.label ?? 'pais'"
        :modelValue="country?.modelValue ?? null"
        :othersProps="{
            url_to_options: '/countries',
            required: country?.othersProps?.required ?? false,
        }"
        @update="onUpdateCountry"
    />
    <select-field
        :name="state?.name ?? 'state_id'"
        :label="state?.label ?? 'pais'"
        :modelValue="state?.modelValue ?? null"
        :othersProps="{
            url_to_options: `/states/${modelCountry}`,
            required: state?.othersProps?.required ?? false,
        }"
        @update="(name, value, full) => emits('update', name, value, full)"
    />
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import SelectField from "./SelectField.vue";

defineOptions({
    name: "StateField",
});

const props = defineProps({
    name: {
        type: String,
    },
    label: {
        type: String,
    },
    country: Object,
    state: Object,
});

const emits = defineEmits(["update"]);

const modelCountry = ref(null);

onMounted(() => {
    modelCountry.value = props.country?.modelValue ?? null;
});

const onUpdateCountry = (name, val) => {
    modelCountry.value = val;
    emits("update", name, val);
};
</script>
