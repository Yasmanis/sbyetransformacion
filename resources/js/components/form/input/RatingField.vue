<template>
    <q-item dense style="padding: 0">
        <q-item-section avatar v-if="label">
            <q-item-label>
                {{ label }}
            </q-item-label>
        </q-item-section>
        <q-item-section>
            <q-rating
                v-model="model"
                :max="max"
                color="primary"
                size="sm"
                @update:model-value="onUpdate"
            />
        </q-item-section>
    </q-item>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";

defineOptions({
    name: "RatingField",
});

const props = defineProps({
    name: {
        type: String,
    },
    label: {
        type: String,
    },
    modelValue: {
        type: Number,
        default: 0,
    },
    max: {
        type: Number,
        default: 5,
    },
    othersProps: Object,
});

const emits = defineEmits(["update", "error"]);

const model = ref(0);

onMounted(() => {
    model.value = props.modelValue;
});

watch(
    () => props.modelValue,
    (n) => {
        model.value = n;
    }
);

const onUpdate = (val) => {
    emits("update", props.name, val);
};
</script>
