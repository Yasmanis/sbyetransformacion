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
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
        v-model="model"
        class="full-width"
        @update:model-value="(val) => update(val)"
    >
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
        <template #after>
            <btn-add-component
                @click="addTopic"
                tooltips="adicionar nuevo tema"
                v-if="btnAdd"
            />
            <btn-delete-component
                @click="deleteTopic"
                tooltips="eliminar tema"
                v-if="btnDelete"
            />
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed } from "vue";
import { validations } from "../../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnAddComponent from "../../../btn/BtnAddComponent.vue";

defineOptions({
    name: "NameComponent",
});

const props = defineProps({
    modelValue: String,
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
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    btnDelete: {
        type: Boolean,
        default: false,
    },
    btnAdd: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["add", "update", "remove"]);

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
    (n, o) => {
        model.value = n;
    }
);

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const addTopic = () => {
    emits("add");
};

function update(val) {
    model.value = val;
    emits("update", props.name, model.value);
}

const deleteTopic = () => {
    emits("remove");
};
</script>
