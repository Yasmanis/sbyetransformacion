<template>
    <q-select
        v-model="model"
        :name="name"
        :label="label"
        :dense="dense"
        :options-dense="dense"
        :clearable="clearable"
        :hidde-bottom-space="hidde_bottom_space"
        :options="options"
        :modelValue="modelValue"
        :filterable="false"
        class="full-width"
        emit-value
        map-options
        @update:model-value="onUpdate"
    />
</template>

<script setup>
import { ref, onBeforeMount, watch } from "vue";

defineOptions({
    name: "BooleanSelectField",
});

const props = defineProps({
    modelValue: Number | String,
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    hidde_bottom_space: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
    },
    label: {
        type: String,
    },
});

const emits = defineEmits(["update", "error"]);

const model = ref(null);

const options = ref([
    {
        label: "si",
        value: "1",
    },
    {
        label: "no",
        value: "0",
    },
]);

watch(
    () => props.modelValue,
    (n, o) => {
        setModelValue();
    }
);

onBeforeMount(() => {
    setModelValue();
});

const setModelValue = () => {
    if (props.modelValue) {
        let option = options.value.find(
            (opt) => opt.value.toString() === props.modelValue.toString()
        );
        model.value = option ? option : null;
    } else {
        model.value = null;
    }
};

const onUpdate = (val) => {
    emits("update", props.name, val);
};
</script>
