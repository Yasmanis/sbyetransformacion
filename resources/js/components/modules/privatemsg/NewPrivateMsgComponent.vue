<template>
    <q-btn-component
        icon="mdi-message-plus-outline"
        tooltips="escribir mensaje"
        @click="showDialog = true"
    />
    <q-dialog v-model="showDialog" persistent allow-focus-outside>
        <q-card>
            <dialog-header-component
                icon="mdi-message-plus-outline"
                title="escribir mensaje privado"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <users-select-dialog-component
                        label="destinatarios"
                        field="users"
                        :required="true"
                        @change="onChangeUsers"
                        v-if="user === 0"
                    />
                    <text-field
                        :modelValue="formData.title"
                        name="title"
                        label="titulo"
                        :othersProps="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <editor-field
                        label="mensaje"
                        v-model="formData.message"
                        :modelValue="formData.message"
                        :othersProps="{
                            required: true,
                        }"
                        name="message"
                        @update="onUpdateField"
                    />
                    <q-list dense v-if="formData.attachments.length > 0">
                        <q-item class="q-ma-none" style="padding: 0">
                            <q-item-section
                                avatar
                                class="q-pa-none"
                                style="min-width: 30px"
                                v-if="formData.attachments?.length > 1"
                            >
                                <btn-delete-component
                                    tooltips="quitar todos los adjuntos"
                                    @click="formData.attachments = []"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>adjuntos</q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-separator></q-separator>
                        <q-item
                            v-for="(f, index) in formData.attachments"
                            :key="`attachment_${index}`"
                            class="q-ma-none"
                            style="padding: 0"
                        >
                            <q-item-section
                                avatar
                                class="q-pa-none"
                                style="min-width: 30px"
                            >
                                <btn-delete-component
                                    tooltips="quitar adjunto"
                                    @click="
                                        formData.attachments.splice(index, 1)
                                    "
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>{{ f.name }}</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-form>
            </q-card-section>

            <q-separator />

            <q-card-actions align="right">
                <q-btn-component
                    icon="mdi-paperclip"
                    tooltips="agregar adjuntos"
                    @click="file_attachment_ref.pickFiles()"
                />
                <btn-send-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-file
        ref="file_attachment_ref"
        multiple
        accept="image/*,.pdf"
        @update:model-value="onChangeAttachment"
        @rejected="error('solo se permiten imagenes y archivos pdf')"
        style="display: none"
    ></q-file>
</template>

<script setup>
import { ref, onBeforeMount } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import UsersSelectDialogComponent from "../user/UsersSelectDialogComponent.vue";
import TextField from "../../form/input/TextField.vue";
import EditorField from "../../form/input/EditorField.vue";
import BtnSendComponent from "../../btn/BtnSendComponent.vue";
import { router, useForm } from "@inertiajs/vue3";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";
import axios from "axios";
import { Loading, Dark } from "quasar";

defineOptions({
    name: "NewPrivateMsgComponent",
});

const props = defineProps({
    user: {
        type: Number,
        default: 0,
    },
    parent: {
        type: Number,
        default: 0,
    },
    title: String,
    enter_image: String,
    leave_image: String,
    tooltips: String,
    size: String,
    padding: String,
});

const emits = defineEmits(["hide-menu"]);

const showDialog = ref(false);
const help = ref(null);
const helpEdit = ref(false);
const formData = useForm({
    title: null,
    message: null,
    attachments: [],
    users: null,
});
const file_attachment_ref = ref(null);
const totalFiles = ref(0);
const upload = ref(false);
const form = ref(null);
const currentMessage = ref(null);
const showInnerLoading = ref(false);

onBeforeMount(() => {});

const onChangeAttachment = (files) => {
    files.forEach((f) => {
        formData.attachments.push(f);
    });
};

const onChangeUsers = (users) => {
    formData.users = users.length > 0 ? users.map((u) => u.id) : null;
};

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const onFinishUploaded = (info) => {
    success("mensaje enviado correctamente");
    Loading.hide();
    showDialog.value = false;
    router.reload({}, "preserveState");
};

const save = async () => {
    form.value.validate().then(async (success) => {
        if (success) {
            formData.post();
            Loading.show();
            const { to, publish, message } = formData;
            await axios
                .post(
                    `/admin/schooltopics/add-message/${
                        props.message ? props.message.topic_id : props.topic.id
                    }`,
                    {
                        to,
                        publish,
                        message,
                        replyTo: props.message?.id,
                    }
                )
                .then((response) => {
                    currentMessage.value = response.data;
                    if (totalFiles.value === 0) {
                        onFinishUploaded();
                    } else {
                        setTimeout(() => {
                            upload.value = true;
                        }, 1000);
                    }
                })
                .catch(() => {
                    Loading.hide();
                });
        } else {
            errorValidation();
        }
    });
};
</script>
