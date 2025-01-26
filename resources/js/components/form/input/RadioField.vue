<template>
    <q-radio
        v-model="model"
        :label="label"
        :left-label="leftLabel"
        :name="name"
        :dense="dense"
        :class="class"
        hide-bottom-space
        bottom-slots
        @update:model-value="onUpdate"
    />
</template>
<script setup>
import { ref, onMounted, watch } from "vue";

defineOptions({
    name: "RadioField",
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
        default: true,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    class: String,
});

const emits = defineEmits(["update"]);

const model = ref(false);

onMounted(() => {
    model.value = props.modelValue;
});

watch(
    () => props.modelValue,
    (n, o) => {
        model.value = props.modelValue;
    }
);

const onUpdate = (val) => {
    emits("update", props.name, val);
};
</script>
