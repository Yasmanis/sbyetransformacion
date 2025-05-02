<template>
    <checkbox-field
        class="q-mt-sm"
        name="file_change"
        :label="`cambiar ${label}`"
        :othersProps="{
            help: [
                othersProps?.helpCheck ??
                    'marque esta casilla si desea reemplazar el archivo existente',
            ],
        }"
        @update="onUpdateCheck"
        v-if="hasFile"
    />
    <q-file
        ref="modelRef"
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        :dense="dense"
        :clearable="clearable"
        :multiple="multiple"
        :accept="othersProps?.accept"
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
        v-model="model"
        class="full-width"
        @rejected="onRejected"
        @update:model-value="(val) => update(val)"
        v-if="!hasFile || fileChange"
    >
        <template #label v-if="label">
            {{ label }}
            <span class="text-red" v-if="othersProps?.required">*</span>
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
        <template #append v-if="othersProps?.icon">
            <q-btn-component
                :icon="othersProps.icon"
                :tooltips="othersProps.titleIcon"
                @click="modelRef.pickFiles()"
            />
        </template>
    </q-file>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import CheckboxField from "./CheckboxField.vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";
import { error } from "../../../helpers/notifications";
defineOptions({
    name: "FileField",
});

const props = defineProps({
    modelValue: String | Object | Array,
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
    change: {
        type: Boolean,
        default: false,
    },
    icon: String,
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
const fileChange = ref(false);
const hasFile = ref(false);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
    if (props.modelValue) {
        hasFile.value = true;
    }
});

onMounted(() => {});

const onUpdateCheck = (name, value) => {
    fileChange.value = value;
    model.value = null;
    emits("update", props.name, null);
};

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
