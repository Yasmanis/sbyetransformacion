<template>
    <btn-add-component @click="showDialog = true" v-if="!object" />
    <btn-edit-component @click="showDialog = true" v-else />

    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
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
                            @update="onUpdateCategory"
                        />
                    </div>
                    <div class="form-field">
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

import { ref, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import SelectField from "../../form/input/SelectField.vue";
import UploaderField from "../../form/input/UploaderField.vue";
import { usePage } from "@inertiajs/vue3";
import { success, errorValidation } from "../../../helpers/notifications";

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
const formFields = ref(null);

const form = ref(null);

const page = usePage();

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = `img:${page.props.public_path}images/icon/black-edit.png`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "mdi-plus";
    }
});

const onHide = () => {
    setDefault.value = !setDefault.value;
    usePage().props.errors = {};
};

const onUpdateCategory = (field, val, full) => {
    formFields.value = [
        {
            name: "category_id",
            value: val,
        },
    ];
};

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            upload.value = true;
        } else {
            errorValidation();
        }
    });
};

const onUploaded = () => {
    emits("save");
    success("fichero(s) adicionado(s) correctamente");
    showDialog.value = false;
};
</script>
