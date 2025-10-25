<template>
    <select-field
        :name="parent.name"
        :label="parent.label"
        :modelValue="parentModel"
        :othersProps="parent.othersProps ?? null"
        @update="onUpdateParent"
    />
    <select-field
        :disable="!parentModel"
        :name="child.name"
        :label="child.label"
        :modelValue="childModel"
        :othersProps="{
            ...child.othersProps,
            url_to_options: parentModel
                ? `${child.othersProps.base_url}/${parentModel}`
                : null,
        }"
        @update="(name, value, full) => emits('update', name, value, full)"
    />
</template>

<script setup>
import { ref, onMounted } from "vue";
import SelectField from "./SelectField.vue";

defineOptions({
    name: "DependsSelectField",
});

const props = defineProps({
    name: {
        type: String,
    },
    label: {
        type: String,
    },
    parentUrl: String,
    childUrl: String,
    parent: Object,
    child: Object,
});

const emits = defineEmits(["update"]);

const parentModel = ref(null);
const childModel = ref(null);

onMounted(() => {
    parentModel.value = props.parent?.modelValue ?? null;
    childModel.value = props.child?.modelValue ?? null;
});

const onUpdateParent = (name, val, full) => {
    parentModel.value = val;
    childModel.value = null;
    emits("update", name, val, full);
};
</script>
