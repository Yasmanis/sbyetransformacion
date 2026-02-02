<template>
    <btn-add-component @click="showDialog = true" v-if="!object" />
    <btn-edit-component @click="showDialog = true" v-else />

    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
        @before-show=""
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="icon"
                :title="
                    object
                        ? `editar ${object[module.toStr]}`
                        : `adicionar ${module.singular_label.toLowerCase()}`
                "
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <div class="form-field">
                        <select-field
                            label="categoria"
                            name="category_id"
                            :othersProps="{
                                required: true,
                                url_to_options: '/categories',
                            }"
                            :filterable="true"
                            @update="onUpdateField"
                        />
                    </div>
                    <div class="form-field">
                        <checkbox-field
                            label="acceso publico"
                            name="public_access"
                            :othersProps="{
                                help: [
                                    'marque esta casilla si desea que el/los fichero(s) tengan acceso publico',
                                ],
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div class="form-field">
                        <select-field
                            name="type"
                            label="tipo"
                            :model-value="type"
                            :clearable="false"
                            :othersProps="{
                                required: true,
                            }"
                            :options="[
                                {
                                    label: 'archivo',
                                    value: 'file',
                                },
                                {
                                    label: 'link',
                                    value: 'link',
                                },
                            ]"
                            :filterable="false"
                            @update="(name, val) => (type = val)"
                        />
                    </div>
                    <div class="form-field" v-if="type === 'file'">
                        <uploader-field
                            ref="uploader"
                            label="ficheros"
                            name="file"
                            required
                            :formFields="formFields"
                            :upload="upload"
                            @uploading="upload = false"
                            @uploaded="onUploaded"
                        />
                    </div>
                    <template v-else>
                        <div class="form-field">
                            <text-field
                                name="name"
                                label="link"
                                :othersProps="{
                                    required: 'true',
                                    type: 'url',
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div class="form-field">
                            <file-field
                                name="poster"
                                label="portada"
                                :othersProps="{
                                    accept: 'image/*',
                                    icon: 'mdi-image-outline',
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </template>

                    <div class="form-field">
                        <date-field
                            label="publicacion"
                            name="public_date"
                            @update="onUpdateField"
                        />
                    </div>
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import UploaderField from "../../form/input/UploaderField.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import FileField from "../../form/input/FileField.vue";
import TextField from "../../form/input/TextField.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { success, errorValidation } from "../../../helpers/notifications";
import { Dark } from "quasar";

const props = defineProps({
    module: {
        type: Object,
        default: () => {},
    },
    size: {
        type: String,
        default: "xs",
    },
    object: {
        type: Object,
        default: null,
    },
    fieldToStr: {
        type: String,
        default: "id",
    },
    title: {
        type: String,
        default: "Object",
    },
    position: {
        type: String,
        default: "right",
    },
    fullHeight: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["save"]);

const upload = ref(false);
const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const setDefault = ref(false);
const formFields = ref([
    {
        name: "category_id",
        value: null,
    },
    {
        name: "public_access",
        value: false,
    },
    {
        name: "public_date",
        value: null,
    },
    {
        name: "poster",
        value: null,
    },
    {
        name: "name",
        value: null,
    },
]);

const form = ref(null);

const page = usePage();

const type = ref("file");

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = `img:${page.props.public_path}images/icon/${
            Dark.isActive ? "white" : "black"
        }-edit.png`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "mdi-plus";
    }
});

watch(type, () => {
    formFields.value
        .filter((f) => ["poster", "name"].includes(f.name))
        .forEach((f) => {
            f.value = null;
        });
});

const initForm = () => {
    formFields.value = [
        {
            name: "category_id",
            value: null,
        },
        {
            name: "public_access",
            value: false,
        },
        {
            name: "public_date",
            value: null,
        },
        {
            name: "poster",
            value: null,
        },
        {
            name: "name",
            value: null,
        },
    ];
};

const onHide = () => {
    setDefault.value = !setDefault.value;
    usePage().props.errors = {};
};

const onUpdateField = (field, val, full) => {
    const f = formFields.value.find((ff) => ff.name === field);
    f.value = val;
};

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            if (type.value === "file") {
                upload.value = true;
            } else {
                let data = {};
                formFields.value.forEach((f) => {
                    data[f.name] = f.value;
                });
                if (data.poster !== null) {
                    data["_method"] = "post";
                }
                const formData = useForm(data);
                formData.post("/admin/files", {
                    onSuccess: () => {
                        showDialog.value = false;
                    },
                });
            }
        } else {
            errorValidation();
        }
    });
};

const onUploaded = () => {
    emits("save");
    success("fichero(s) adicionado(s) correctamente");
    showDialog.value = false;
    initForm();
};
</script>
