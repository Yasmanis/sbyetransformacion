<template>
    <q-file
        :ref="modelRef"
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        :dense="dense"
        :clearable="clearable"
        :multiple="multiple"
        :accept="accept"
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
        v-model="model"
        class="full-width"
        @rejected="onRejected"
        @update:model-value="(val) => update(val)"
    />
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed } from "vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";
import { error } from "../../../helpers/notifications";
defineOptions({
    name: "FileField",
});

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    accept: String,
    othersProps: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update"]);

const page = usePage();

const model = ref(null);
const modelRef = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const update = (val) => {
    model.value = val;
    emits("update", props.name, model.value);
};

const onRejected = () => {
    error("fichero no admitido");
};
</script>
