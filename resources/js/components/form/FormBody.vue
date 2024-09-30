<template>
    <q-card-section class="col q-pt-none">
        <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
            <div
                class="form-field"
                v-for="(f, index) in fields"
                :key="`field-${index}`"
            >
                <text-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-if="f.type === 'text'"
                />
                <checkbox-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="object ? object[f.name] : false"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'boolean'"
                />
                <select-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    :options="f.options"
                    :othersProps="f.othersProps"
                    :filterable="f.filterable"
                    :multiple="f?.othersProps?.multiple ?? false"
                    @update="onUpdateField"
                    v-else-if="f.type === 'select'"
                />
                <date-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="object ? object[f.name] : null"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'date'"
                />
                <password-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="object ? object[f.name] : null"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    @confirm="onUpdateField"
                    v-else-if="f.type === 'password'"
                />
            </div>
        </q-form>
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
        <q-btn-component
            label="guardar"
            outline
            square
            size="md"
            padding="5px"
            no_caps
            @click="save(true)"
        />
        <q-btn-component
            label="guardar y adicionar otro"
            outline
            square
            size="md"
            padding="5px"
            no_caps
            @click="save(false)"
            v-if="!object"
        />
        <q-btn-component
            label="cancelar"
            outline
            square
            size="md"
            padding="5px"
            color="red"
            no_caps
            v-close-popup
        />
    </q-card-actions>
</template>

<script setup>
defineOptions({
    name: "FormBody",
});

import { ref, onBeforeMount } from "vue";
import TextField from "./input/TextField.vue";
import SelectField from "./input/SelectField.vue";
import CheckboxField from "./input/CheckboxField.vue";
import DateField from "./input/DateField.vue";
import PasswordField from "./input/PasswordField.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorException, errorValidation } from "../../helpers/notifications";

const props = defineProps({
    module: {
        type: Object,
        default: () => {},
    },
    object: {
        type: Object,
        default: null,
    },
    fields: {
        type: Array,
        default: () => [],
    },
});

const emits = defineEmits(["close"]);

const form = ref(null);

const formData = ref({});

onBeforeMount(() => {
    setDefaultData();
});

const setDefaultData = () => {
    props.fields.forEach((f) => {
        if (f.type === "boolean") {
            formData.value[f.name] = false;
        } else if (f.type === "select") {
            formData.value[f.name] = [];
        } else {
            formData.value[f.name] = null;
        }
    });
};

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            saveRecord(hide);
        } else {
            errorValidation();
        }
    });
};

const saveRecord = async (hide) => {
    try {
        const send = useForm(formData.value);
        send.post(props.module.base_url, {
            onSuccess: () => {
                setDefaultData();
                if (hide) {
                    emits("close");
                } else {
                    // setDefaultData();
                    // form.value.reset();
                }
            },
        });
        //form.value.resetValidation();
    } catch (e) {
        errorException(e);
    } finally {
    }
};
</script>
