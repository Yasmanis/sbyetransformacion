<template>
    <q-checkbox
        v-model="model"
        :label="label"
        :left-label="leftLabel"
        :name="name"
        :dense="dense"
        :class="class"
        :style="style"
        :disable="disable"
        hide-bottom-space
        bottom-slots
        @update:model-value="onUpdate"
    >
        <template #label v-if="label">
            {{ label }}
        </template>
    </q-checkbox>
    <div
        class="q-field__bottom row items-start q-field__bottom--stale"
        style="padding-left: 0px"
        v-if="fieldHelp.length > 0"
    >
        <div class="q-field__messages col">
            <ul style="padding: 0px; margin-top: 0px; margin-bottom: 0px">
                <li
                    class="text-help"
                    v-for="(h, index) in fieldHelp"
                    :key="`help-field-${index}`"
                    :style="{
                        'list-style': 'none',
                    }"
                >
                    {{ h }}
                </li>
            </ul>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onBeforeMount, watch } from "vue";
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
        default: true,
    },
    disable: {
        type: Boolean,
        default: false,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    class: String,
    style: Object,
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
