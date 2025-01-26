<template>
    <q-btn-component
        tooltips="contacto"
        icon="mdi-message-question-outline"
        color="white"
        class="q-mr-sm"
        @click="showDialog = true"
    />
    <q-dialog v-model="showDialog" persistent position="right" @hide="onHide">
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-message-question-outline"
                title="escribir a sbye-transformacion"
                closable
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
                    <uploader-field label="adjuntos" name="attachments" />
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
import { useForm } from "@inertiajs/vue3";
import { errorValidation, error } from "../../helpers/notifications";
defineOptions({
    name: "ContactComponent",
});

const showDialog = ref(false);
const form = ref(null);
const formData = useForm({
    subject: null,
    description: null,
});

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const save = () => {
    form.value.validate().then((success) => {
        if (success) {
            if (
                formData.description === null ||
                formData.description.trim() === ""
            ) {
                error("especifique en que desea que lo/la ayudemos");
            } else {
                formData.post("/admin/contact-admin/store", {
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

const onHide = () => {
    formData.reset();
    form.value.resetValidation();
};
</script>
