<template>
    <q-item clickable @click="showDialog = true" v-if="message">
        <q-item-section
            avatar
            style="padding-right: 5px !important; min-width: 0px !important"
        >
            <q-icon
                name="mdi-arrow-up-right fa-rotate-270"
                size="22px"
            ></q-icon>
        </q-item-section>

        <q-item-section>responder</q-item-section>
    </q-item>
    <q-btn-component
        icon="mdi-chat-processing-outline"
        tooltips="usar chat"
        flat
        size="md"
        padding="5px"
        @click="showDialog = true"
        v-else
    />
    <q-dialog
        v-model="showDialog"
        persistent
        full-width
        seamless
        @hide="onHide"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-chat-processing-outline"
                title="escribir en el chat "
                closable
            />
            <q-card-section>
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <select-field
                        :modelValue="formData.to"
                        :clearable="false"
                        :filterable="false"
                        name="to"
                        label="destinatario"
                        :othersProps="{ required: true }"
                        :options="[
                            { label: 'todos', value: 'todos' },
                            {
                                label: 'sbye dieta',
                                value: 'sbye_dieta',
                            },
                        ]"
                        @update="onUpdateField"
                    />
                    <select-field
                        :modelValue="formData.publish"
                        :clearable="false"
                        :filterable="false"
                        name="publish"
                        label="tu usuario para publicar"
                        :othersProps="{
                            required: true,
                        }"
                        :options="[
                            { label: 'visible', value: 'visible' },
                            {
                                label: 'oculto',
                                value: 'oculto',
                            },
                        ]"
                        @update="onUpdateField"
                    />
                    <editor-field
                        :modelValue="formData.message"
                        name="message"
                        label="mensaje"
                        :othersProps="{
                            required: true,
                        }"
                        :rows="3"
                        @update="onUpdateField"
                    />
                    <uploader-field
                        label="adjuntos"
                        :formFields="[
                            {
                                name: 'msg',
                                value: currentMessage?.id,
                            },
                        ]"
                        :upload="upload"
                        :noThumbnails="true"
                        url="/admin/schooltopics/add-attachment-message"
                        @uploaded="onUploaded"
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
import { ref, onBeforeMount } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import BtnSaveComponent from "../../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import SelectField from "../../../form/input/SelectField.vue";
import EditorField from "../../../form/input/EditorField.vue";
import UploaderField from "../../../form/input/UploaderField.vue";
import { router } from "@inertiajs/vue3";
import {
    error,
    errorValidation,
    success,
} from "../../../../helpers/notifications";
import axios from "axios";
import { Loading } from "quasar";

defineOptions({
    name: "HelpChatComponent",
});

const props = defineProps({
    topic: Object,
    message: Object,
});

const emits = defineEmits(["hide-menu"]);

const showDialog = ref(false);
const help = ref(null);
const formData = ref({
    topic: null,
    to: "todos",
    publish: "oculto",
    message: null,
    files: [],
    replyTo: null,
});
const totalFiles = ref(0);
const upload = ref(false);
const form = ref(null);
const currentMessage = ref(null);

onBeforeMount(() => {
    axios
        .get("/admin/configuration/index/help_chat")
        .then((data) => {
            help.value = data.data.value ?? "";
        })
        .catch(() => {});
});

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const onUploaded = (name, val) => {
    // router.post("/admin/configuration/save", {
    //     keyName: "help_chat",
    //     keyValue: help.value,
    // });
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
            if (
                formData.value["message"] === null ||
                formData.value["message"].trim() === ""
            ) {
                error("debe especificar el mensaje");
            } else {
                Loading.show();
                const { to, publish, message } = formData.value;
                await axios
                    .post(
                        `/admin/schooltopics/add-message/${
                            props.message
                                ? props.message.topic_id
                                : props.topic.id
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
            }
        } else {
            errorValidation();
        }
    });
};

const onHide = () => {
    if (props.message) {
        emits("hide-menu");
    }
};
</script>
