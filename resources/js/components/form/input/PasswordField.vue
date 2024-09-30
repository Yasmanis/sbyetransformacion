<template>
    <q-input
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="errorPwd !== null"
        :error-message="errorPwd"
        :dense="dense"
        :clearable="clearable"
        hide-bottom-space
        bottom-slots
        v-model="model"
        :type="isPwd ? 'password' : 'text'"
        class="full-width"
        @update:model-value="onChangePassword"
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
        <template v-slot:append>
            <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
            />
        </template>
    </q-input>
    <q-input
        v-model="modelConfirm"
        name="password_confirm"
        label="confirmar contraseña"
        :rules="[
            (val) => !!val || 'requerido',
            (val) => val === model || 'las contraseñas no coinciden',
        ]"
        :error="errorConfirm !== null"
        :error-message="errorConfirm"
        :dense="dense"
        :clearable="clearable"
        hide-bottom-space
        bottom-slots
        :type="isPwd ? 'password' : 'text'"
        class="full-width"
        @update:model-value="onChangeConfirm"
    >
        <template #hint>
            <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                <li style="list-style: none">requerido</li>
                <li style="list-style: none">igual que la anterior</li>
            </ul>
        </template>
        <template v-slot:append>
            <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
            />
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, computed } from "vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "PasswordField",
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
});

const emits = defineEmits(["update", "confirm"]);
const page = usePage();
const model = ref(null);
const modelConfirm = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);
const isPwd = ref(true);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

onMounted(() => {
    model.value = props.modelValue;
});

const errorPwd = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const errorConfirm = computed(() => {
    let name = `${props.name}_confirmed`;
    return page.props.errors
        ? page.props.errors[name]
            ? page.props.errors[name]
            : null
        : null;
});

const onChangePassword = (val) => {
    emits("update", props.name, val);
};

const onChangeConfirm = (val) => {
    emits("confirm", `${props.name ? props.name : "password"}_confirmed`, val);
};
</script>
