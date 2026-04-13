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
                    v-if="formData.type === 'folder'"
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
import { useForm } from "@inertiajs/vue3";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";

const props = defineProps({
    parent: Object,
    user: Object,
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
    formData.value["name"] = object?.name ?? null;
    formData.value["user_id"] = props.user.id;
};

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (!formData.value.is_folder && files.value === 0) {
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

const store = async (hide) => {
    if (formData.value.is_folder) {
        const send = useForm({
            ...formData.value,
            user_id: props.user.id,
        });
        send.post("/admin/documents", {
            onSuccess: () => {
                setDefaultData();
                emits("created", null, hide);
            },
        });
    } else {
        upload.value = true;
    }
};

const update = async (hide) => {
    formData.value["_method"] = "put";
    const send = useForm(formData.value);
    send.post(`${props.module.base_url}/${props.object.id}`, {
        onSuccess: () => {
            setDefaultData();
            emits("updated", null, hide);
        },
    });
};

const onUploaded = () => {
    emits("created");
    success("fichero(s) adicionado(s) correctamente");
};

const onChangeFiles = (f) => {
    files.value = f;
};
</script>
