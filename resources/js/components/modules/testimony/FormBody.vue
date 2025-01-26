<template>
    <q-card-section class="col q-pt-none">
        <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
            <div class="form-field">
                <text-field
                    v-model="formData['name_to_show']"
                    label="nombre a mostrar"
                    name="name_to_show"
                    :modelValue="formData['name_to_show']"
                    @update="onUpdateField"
                />
                <checkbox-field
                    label="marca esta casilla si quieres hacer un testimonio anonimo, aunque es preferible que utilices un pseudonimo o solo tu nombre o diminutivo"
                    name="anonimous"
                    class="q-mt-sm"
                    :modelValue="formData['anonimous']"
                    @update="onUpdateField"
                />
                <text-field
                    v-model="formData['title']"
                    label="titulo"
                    name="title"
                    :othersProps="{
                        required: true,
                    }"
                    :modelValue="formData['title']"
                    @update="onUpdateField"
                />
                <select-field
                    label="tipo"
                    name="type"
                    :modelValue="formData['type']"
                    :options="[
                        {
                            label: 'texto',
                            value: 'text',
                        },
                        {
                            label: 'video',
                            value: 'video',
                        },
                    ]"
                    :othersProps="{
                        required: true,
                    }"
                    :filterable="false"
                    @update="onUpdateType"
                    v-if="object === null"
                />
                <editor-field
                    v-model="formData['message']"
                    label="mensaje"
                    name="message"
                    :othersProps="{
                        required: true,
                    }"
                    @update="onUpdateField"
                    v-if="
                        formData['type'] === 'text' ||
                        (object && object.type === 'text')
                    "
                />
                <file-field
                    v-model="formData['file']"
                    label="mensaje"
                    name="file"
                    :autogrow="true"
                    :othersProps="{ required: true, accept: 'video/*' }"
                    :modelValue="formData['file']"
                    @update="onUpdateField"
                    v-if="formData['type'] === 'video'"
                />
                <text-field
                    v-model="formData['msg_to_admin']"
                    label="mensaje al admin"
                    name="msg_to_admin"
                    type="textarea"
                    :autogrow="true"
                    :modelValue="formData['msg_to_admin']"
                    @update="onUpdateField"
                />
            </div>
        </q-form>
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
        <btn-save-component @click="save(true)" />
        <btn-cancel-component :cancel="true" @click="emits('close')" />
    </q-card-actions>
</template>

<script setup>
defineOptions({
    name: "FormBody",
});

import { ref, onBeforeMount } from "vue";
import TextField from "../../form/input/TextField.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import SelectField from "../../form/input/SelectField.vue";
import FileField from "../../form/input/FileField.vue";
import EditorField from "../../form/input/EditorField.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { error, errorValidation } from "../../../helpers/notifications";

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

const onUpdateType = (name, val) => {
    formData.value[name] = val;
    formData.value["message"] = null;
    formData.value["file"] = null;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (formData.value.type === "text" && !formData.value.message) {
                error("debe especificar el mensaje");
            } else {
                if (props.object) {
                    update();
                } else {
                    store(hide);
                }
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
