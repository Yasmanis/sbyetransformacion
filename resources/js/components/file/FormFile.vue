<template>
    <q-btn-component
        :tooltips="object === null ? 'adicionar' : 'editar'"
        :icon="icon"
        :size="size"
        @click="showDialog = true"
    />

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
                            name="files"
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
                <q-btn-component
                    label="guardar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    no_caps
                    icon="mdi-content-save-outline"
                    @click="save"
                />
                <q-btn-component
                    label="cancelar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    color="red"
                    no_caps
                    icon="mdi-close-circle-outline"
                    v-close-popup
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormFile",
});

import { ref, onMounted } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import SelectField from "../form/input/SelectField.vue";
import UploaderField from "../form/input/UploaderField.vue";
import { usePage } from "@inertiajs/vue3";
import { success, errorValidation } from "../../helpers/notifications";

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

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = "edit";
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "add";
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
