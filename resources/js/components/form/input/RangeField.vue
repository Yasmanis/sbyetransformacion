<template>
    <q-list dense style="width: 100%">
        <q-item style="padding: 0" v-if="label">
            <q-item-section>
                <q-item-label> {{ label }} {{ range }} </q-item-label>
            </q-item-section>
        </q-item>
        <q-item style="padding: 0px; padding-left: 7px; padding-right: 7px">
            <q-item-section>
                <q-range
                    v-model="model"
                    :model-value="
                        modelValue ? modelValue : { min: min, max: max }
                    "
                    :name="name"
                    :min="min"
                    :max="max"
                    drag-range
                    label
                    @change="onUpdate"
                />
            </q-item-section>
            <q-item-section
                avatar
                style="margin-right: -10px"
                v-if="model && (model.min !== min || model.max !== max)"
            >
                <q-icon
                    name="cancel"
                    class="cursor-pointer text-grey"
                    @click="clear"
                />
            </q-item-section>
        </q-item>
    </q-list>
</template>
<script setup>
import { computed, onBeforeMount, ref } from "vue";

defineOptions({
    name: "RangeField",
});

const props = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    min: {
        type: Number,
        required: true,
    },
    max: {
        type: Number,
        required: true,
    },
});

const emits = defineEmits(["update"]);

const model = ref(null);

onBeforeMount(() => {
    model.value = props.modelValue ?? {
        min: props.min,
        max: props.max,
    };
});

const range = computed(() => {
    if (model.value) {
        return `${model.value.min} - ${model.value.max}`;
    }
    return null;
});

const onUpdate = (val) => {
    if (val.min === props.min && val.max === props.max) {
        emits("update", props.name, null);
    } else {
        emits("update", props.name, val);
    }
};

const clear = () => {
    model.value = null;
    emits("update", props.name, null);
};
</script>
