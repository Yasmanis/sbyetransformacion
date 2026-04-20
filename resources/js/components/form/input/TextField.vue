<template>
    <q-input
        :ref="modelRef"
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        :dense="dense"
        :clearable="clearable"
        :type="type"
        :autogrow="autogrow"
        :readonly="othersProps?.readonly ?? false"
        :disable="othersProps?.disable ?? false"
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
        v-model="model"
        class="full-width"
        :input-style="inputStyle"
        @update:model-value="(val) => update(val)"
    >
        <template #label v-if="label">
            <span :style="labelStyle">{{ label }}</span>
            <span class="text-red" v-if="othersProps?.required">*</span>
        </template>
        <template v-slot:before v-if="$slots.before">
            <slot name="before"></slot> </template
        ><template v-slot:after v-if="$slots.after">
            <slot name="after"></slot> </template
        ><template v-slot:append v-if="$slots.append">
            <slot name="append"></slot>
        </template>
        <template #hint v-if="fieldHelp?.length > 0">
            <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                <li
                    v-for="(h, index) in fieldHelp"
                    :key="`help-${index}`"
                    style="list-style: none"
                >
                    {{ h }}
                </li>
            </ul>
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed } from "vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "TextField",
});

const props = defineProps({
    modelValue: String | Number,
    name: {
        type: String,
        required: true,
    },
    label: String,
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    autogrow: {
        type: Boolean,
        default: false,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    type: {
        type: String,
        default: "text",
    },
    highlighteds: Object,
});

const emits = defineEmits(["update"]);

const page = usePage();

const model = ref("");
const modelRef = ref(null);
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

watch(
    () => props.modelValue,
    (n) => {
        model.value = n === "" ? null : n;
    },
);

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const highlighted = computed(() => {
    let highlighteds = props.highlighteds;
    return model.value && highlighteds ? highlighteds[props.name] : null;
});

const inputStyle = computed(() => {
    let h = highlighted.value,
        style = {};
    if (h) {
        if (h.bColor) {
            style["background-color"] = h.bColor;
        }
        if (h.tColor) {
            style["color"] = h.tColor;
        }
    }
    return style;
});

const labelStyle = computed(() => {
    let h = highlighted.value,
        style = {};
    if (h && h.tColor) {
        style["color"] = h.tColor;
    }
    return style;
});

function update(val) {
    model.value = val;
    emits("update", props.name, model.value);
}
</script>
