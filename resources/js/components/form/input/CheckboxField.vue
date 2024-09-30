<template>
    <q-checkbox
        v-model="model"
        :label="label"
        :left-label="leftLabel"
        :name="name"
        :dense="dense"
        hide-bottom-space
        bottom-slots
        @update:model-value="onUpdate"
    >
    </q-checkbox>
</template>
<script setup>
import { ref, onMounted, onBeforeMount } from "vue";
import { validations } from "../../../helpers/validations";

defineOptions({
    name: "CheckboxField",
});

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
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
    dense: {
        type: Boolean,
        default: false,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update"]);

const model = ref(false);
const fieldRules = ref([]);
const fieldHelp = ref([]);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

onMounted(() => {
    model.value = props.modelValue;
});

const onUpdate = (val) => {
    emits("update", props.name, val);
};
</script>
