<template>
    <q-card-section class="col q-pt-none">
        <q-form class="q-mt-sm" ref="form" greedy>
            <div class="form-field">
                <select-field
                    label="tipo"
                    name="type"
                    :modelValue="formData['type']"
                    :options="[
                        {
                            label: 'carpeta',
                            value: 'folder',
                        },
                        {
                            label: 'archivo',
                            value: 'file',
                        },
                    ]"
                    :othersProps="{
                        required: true,
                    }"
                    :filterable="false"
                    class="q-mb-md"
                    @update="onUpdateField"
                    v-if="!object"
                />
                <text-field
                    v-model="formData['name']"
                    label="nombre"
                    name="name"
                    :othersProps="{
                        required: true,
                    }"
                    :modelValue="formData['name']"
                    @update="onUpdateField"
                    v-if="formData.type === 'folder' || object"
                />
                <uploader-field
                    ref="uploader"
                    label="ficheros"
                    name="file"
                    required
                    :url="`/admin/documents`"
                    :formFields="formFields"
                    :upload="upload"
                    @uploading="upload = false"
                    @uploaded="onUploaded"
                    @change-files="onChangeFiles"
                    v-else
                />
                <text-field
                    autogrow
                    class="q-mt-sm"
                    name="description"
                    label="descripcion"
                    :modelValue="formData['description']"
                    @update="onUpdateField"
                />
                <text-field
                    autogrow
                    class="q-mt-sm"
                    name="observation"
                    label="observaciones"
                    :modelValue="formData['observation']"
                    @update="onUpdateField"
                />
            </div>
        </q-form>
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
        <btn-save-component @click="save(true)" />
        <btn-cancel-component :cancel="true" @click="emits('cancel')" />
    </q-card-actions>
</template>

<script setup>
defineOptions({
    name: "FormBody",
});

import { ref, onBeforeMount, watch } from "vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import UploaderField from "../../form/input/UploaderField.vue";
import EditorField from "../../form/input/EditorField.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";
import { Loading } from "quasar";

const props = defineProps({
    parent: Object,
    user: Object,
    object: Object,
});

const emits = defineEmits(["created", "updated", "cancel"]);

const form = ref(null);
const files = ref(0);
const formData = ref({});
const upload = ref(false);
const formFields = ref([
    {
        name: "parent_id",
        value: props.parent?.id ?? null,
    },
    {
        name: "user_id",
        value: props.user.id,
    },
    {
        name: "observation",
        value: formData.value.observation,
    },
    {
        name: "description",
        value: formData.value.description,
    },
]);

onBeforeMount(() => {
    setDefaultData();
});

watch(
    () => formData.value.type,
    (n) => {
        formData.value["is_folder"] = n === "folder";
    },
);

const setDefaultData = () => {
    const object = props.object;
    formData.value["type"] = object?.type ?? "folder";
    formData.value["name"] = object
        ? object.is_folder
            ? object.name
            : object.name.substring(0, object.name.lastIndexOf("."))
        : null;
    formData.value["user_id"] = props.user.id;
    formData.value["parent_id"] = props.parent?.id ?? null;
    formData.value["observation"] = object?.observation ?? null;
    formData.value["description"] = object?.description ?? null;
};

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (
                !formData.value.is_folder &&
                files.value === 0 &&
                !props.object
            ) {
                error("debe agregar al menos un archivo");
            } else {
                if (props.object) {
                    update(hide);
                } else {
                    store(hide);
                }
            }
        } else {
            errorValidation();
        }
    });
};

const store = async () => {
    if (formData.value.is_folder) {
        const send = useForm({
            ...formData.value,
            user_id: props.user.id,
            parent_id: props.parent?.id ?? null,
        });
        send.post("/admin/documents", {
            onSuccess: () => {
                emits("created");
            },
        });
    } else {
        let f = formFields.value.find((f) => f.name === "description");
        if (f) {
            f.value = formData.value.description;
        }
        f = formFields.value.find((f) => f.name === "observation");
        if (f) {
            f.value = formData.value.observation;
        }
        upload.value = true;
        Loading.show();
    }
};

const update = async () => {
    let { name, description, observation } = formData.value;
    const send = useForm({
        name,
        description,
        observation,
    });
    send.put(`/admin/documents/${props.object.id}`, {
        onSuccess: () => {
            emits("updated");
        },
    });
};

const onUploaded = () => {
    router.reload();
    Loading.hide();
    success("fichero(s) adicionado(s) correctamente");
    emits("created");
};

const onChangeFiles = (f) => {
    files.value = f;
};
</script>
