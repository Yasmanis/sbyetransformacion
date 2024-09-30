<template>
    <q-select
        v-model="model"
        :dense="dense"
        :options-dense="dense"
        :name="name"
        :label="label"
        :multiple="multiple"
        :clearable="clearable"
        :options="allOptions"
        :use-input="filterable"
        :use-chips="multiple && chips"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        hide-bottom-space
        emit-value
        map-options
        class="full-width"
        @filter="filterFn"
        @update:model-value="(val) => updateModel(val)"
    >
    </q-select>
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "SelectField",
});

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    filterable: {
        type: Boolean,
        default: true,
    },
    hidde_bottom_space: {
        type: Boolean,
        default: true,
    },
    name: {
        type: String,
    },
    label: {
        type: String,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    chips: {
        type: Boolean,
        default: true,
    },
    options: {
        type: Array,
        default: () => [],
    },
    optionValue: {
        type: String,
        default: "value",
    },
    optionLabel: {
        type: String,
        default: "label",
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update", "error"]);

const page = usePage();
const model = ref(null);

const currentOptions = ref([]);
const allOptions = ref([]);

onMounted(() => {
    setData();
});

watch(
    () => props.modelValue,
    (n, o) => {
        setModelValue();
    }
);

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const setData = async () => {
    await setDataFromServer();
    if (currentOptions.value.length === 0) {
        currentOptions.value = props.options;
    } else {
        props.options.forEach((o) => {
            currentOptions.value.push(o);
        });
    }
    allOptions.value = currentOptions.value;
    setModelValue();
};

const setDataFromServer = async () => {
    if (props?.othersProps?.url_to_options) {
        await axios
            .get(props.othersProps.url_to_options)
            .then((response) => {
                currentOptions.value = response.data.options;
            })
            .catch((error) => {
                currentOptions.value = [];
            });
    }
};

const setModelValue = () => {
    if (props.modelValue?.length > 0) {
        let current_selected = [];
        props.modelValue.forEach((o) => {
            let option = currentOptions.value.find((opt) => opt.value === o);
            if (option) {
                current_selected.push(option);
            }
        });
        model.value = props.multiple ? current_selected : current_selected[0];
    } else {
        model.value = null;
    }
};

const filterFn = (val, update, abort) => {
    setTimeout(() => {
        update(
            () => {
                if (val === "") {
                    currentOptions.value = allOptions.value;
                } else {
                    const needle = val.toLowerCase();
                    currentOptions.value = allOptions.value.filter((v) =>
                        v.label
                            ? v.label.toLowerCase().indexOf(needle) > -1
                            : v.toLowerCase().indexOf(needle) > -1
                    );
                }
            },
            (ref) => {
                if (
                    val !== "" &&
                    ref.options.length > 0 &&
                    ref.getOptionIndex() === -1
                ) {
                    ref.moveOptionSelection(1, true);
                    ref.toggleOption(ref.options[ref.optionIndex], true);
                }
            }
        );
    }, 100);
};

const updateModel = (val) => {
    let selected = null;
    if (val) {
        if (props.multiple) {
            selected = [];
            val.forEach((v) => {
                if (v["value"] !== undefined && v["value"] !== null) {
                    selected.push(v["value"]);
                } else {
                    selected.push(v);
                }
            });
        } else {
            if (val["value"] !== undefined && val["value"] !== null) {
                selected = val["value"];
            } else {
                selected = val;
            }
        }
    }
    let full_option = null;
    if (selected) {
        if (props.multiple) {
            full_option = [];
            selected.forEach((s) => {
                let opt = currentOptions.value.find((o) => o.value === s);
                if (opt) {
                    full_option.push(opt);
                }
            });
        } else {
            full_option = currentOptions.value.find((o) => o.value === val);
        }
    }
    emits("update", props.name, selected, full_option);
};
</script>
