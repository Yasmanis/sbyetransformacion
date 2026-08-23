<template>
    <q-input
        v-model="model"
        mask="time"
        :rules="fieldRules"
        :ref="modelRef"
        :name="props.name"
        :label="props.label"
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
        class="full-width"
        :input-style="inputStyle"
        @update:model-value="(val) => update(val)"
    >
        <template v-slot:append>
            <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                >
                    <q-time v-model="model">
                        <div class="row items-center justify-end">
                            <q-btn
                                v-close-popup
                                label="Close"
                                color="primary"
                                flat
                            />
                        </div>
                    </q-time>
                </q-popup-proxy>
            </q-icon>
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed, nextTick } from "vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "TimeField",
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
