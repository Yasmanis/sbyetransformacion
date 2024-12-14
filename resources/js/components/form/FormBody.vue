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
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-if="f.type === 'text'"
                />
                <checkbox-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'boolean'"
                />
                <uploader-field
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'uploader'"
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
                    :modelValue="formData[f.name]"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'date'"
                />
                <password-field
                    :label="f.label"
                    :name="f.name"
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
        <btn-save-component @click="save(true)" />
        <btn-save-and-new-component @click="save(false)" v-if="!object" />
        <btn-cancel-component :cancel="true" @click="emits('close')" />
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
import UploaderField from "./input/UploaderField.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../btn/BtnSaveAndNewComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

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
            formData.value[f.name] = props.object
                ? props.object[f.name]
                : false;
        } else if (f.type === "select") {
            formData.value[f.name] = props.object ? props.object[f.name] : null;
        } else {
            formData.value[f.name] = props.object ? props.object[f.name] : null;
        }
    });
};

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (props.object) {
                update();
            } else {
                store(hide);
            }
        } else {
            errorValidation();
        }
    });
};

const store = async (hide) => {
    const send = useForm(formData.value);
    send.post(props.module.base_url, {
        onSuccess: () => {
            setDefaultData();
            if (hide) {
                emits("close");
            }
        },
    });
};

const update = async (hide) => {
    const send = useForm(formData.value);
    send.put(`${props.module.base_url}/${props.object.id}`, {
        onSuccess: () => {
            setDefaultData();
            emits("close");
        },
    });
};
</script>
