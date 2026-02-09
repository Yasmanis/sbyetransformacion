<template>
    <q-item-label
        class="cursor-pointer"
        style="margin-right: 30px"
        @click="showDialog = true"
        >contactar</q-item-label
    >
    <q-dialog v-model="showDialog" persistent position="right" @hide="onHide">
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-message-question-outline"
                title="escribir a sbye-transformacion"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <text-field
                        label="nombre"
                        name="subject"
                        v-model="formData.subject"
                        :model-value="formData.subject"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <editor-field
                        label="en que podemos ayudarte"
                        name="description"
                        v-model="formData.description"
                        :model-value="formData.description"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <uploader-field
                        label="adjuntos"
                        name="file"
                        url="/admin/tikets/add-attachment"
                        :formFields="[
                            {
                                name: 'id',
                                value: tiket?.id,
                            },
                        ]"
                        :noThumbnails="true"
                        :upload="upload"
                        @change-files="
                            (files) => {
                                totalFiles = files;
                            }
                        "
                        @finish="onFinishUploaded"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import TextField from "../form/input/TextField.vue";
import EditorField from "../form/input/EditorField.vue";
import UploaderField from "../form/input/UploaderField.vue";
import { errorValidation, error, success } from "../../helpers/notifications";
import { Loading } from "quasar";
import axios from "axios";
import { router } from "@inertiajs/vue3";
defineOptions({
    name: "ContactComponent",
});

const showDialog = ref(false);
const form = ref(null);
const formData = ref({
    subject: null,
    description: null,
});
const tiket = ref(null);
const upload = ref(false);
const totalFiles = ref(0);

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const save = () => {
    form.value.validate().then(async (success) => {
        if (success) {
            if (
                formData.value.description === null ||
                formData.value.description.trim() === ""
            ) {
                error("especifique en que desea que lo/la ayudemos");
            } else {
                Loading.show();
                await axios
                    .post("/admin/tikets", formData.value)
                    .then((response) => {
                        if (response.data.success) {
                            tiket.value = response.data.object;
                            if (totalFiles.value === 0) {
                                onFinishUploaded();
                            } else {
                                setTimeout(() => {
                                    upload.value = true;
                                }, 1000);
                            }
                        } else {
                            error("error al tratar de enviar esta solicitud");
                        }
                    })
                    .catch(() => {
                        error("error al tratar de enviar esta solicitud");
                        Loading.hide();
                    });
            }
        } else {
            errorValidation();
        }
    });
};

const onHide = () => {
    formData.value = {
        subject: null,
        description: null,
    };
    form.value.resetValidation();
};

const onFinishUploaded = () => {
    success("solicitud enviada correctamente");
    Loading.hide();
    showDialog.value = false;
    upload.value = false;
    router.reload({}, "preserveState");
};
</script>
