<template>
    <q-menu touch-position context-menu ref="menu">
        <q-list bordered dense>
            <form-chat-component
                :message="currentMessage"
                @hide-menu="menu.hide()"
            />
            <q-item
                clickable
                v-close-popup
                @click="reactHighligthDelete('react')"
            >
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon
                        name="mdi-emoticon-happy-outline"
                        size="22px"
                    ></q-icon>
                </q-item-section>

                <q-item-section>reaccionar</q-item-section>
            </q-item>

            <q-item
                clickable
                v-close-popup
                @click="reactHighligthDelete('highligth')"
            >
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon name="mdi-star-outline" size="22px"></q-icon>
                </q-item-section>

                <q-item-section>destacar</q-item-section>
            </q-item>

            <q-item
                clickable
                v-if="currentMessage.owner"
                @click="showDialog = true"
            >
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon
                        :name="`img:${$page.props.public_path}images/icon/${
                            Dark.isActive ? 'white' : 'black'
                        }-edit.png`"
                        size="22px"
                    ></q-icon>
                </q-item-section>
                <q-item-section>editar</q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="confirm = true">
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon name="mdi-trash-can-outline" size="22px"></q-icon>
                </q-item-section>

                <q-item-section>eliminar</q-item-section>
            </q-item>
        </q-list>
    </q-menu>

    <confirm-component
        :show="confirm"
        @ok="
            router.delete(
                `/admin/schooltopics/delete-message/${currentMessage?.id}`,
                {
                    onSuccess: () => {
                        confirm = false;
                    },
                }
            )
        "
        @hide="confirm = false"
        title="confirmar eliminacion"
        message="seguro que deseas eliminar este mensaje"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        draggable
        :maximized="maximizedToggle"
        @show="onShow"
        @hide="onHide"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-chat-processing-outline"
                title="editar mensaje"
                maximizeable
                closable
                @fullsize="(s) => (maximizedToggle = s)"
                @close="showDialog = false"
            />

            <q-card-section
                :style="{
                    'max-height': maximizedToggle ? '' : '50vh',
                }"
                class="scroll"
            >
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <editor-field
                        v-model="formData.message"
                        name="message"
                        label="mensaje"
                        :othersProps="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <q-list
                        dense
                        v-if="currentMessage?.attachments?.length > 0"
                    >
                        <q-item class="q-ma-none" style="padding: 0">
                            <q-item-section
                                avatar
                                class="q-pa-none"
                                style="min-width: 30px"
                                v-if="currentMessage.attachments?.length > 1"
                            >
                                <btn-delete-component
                                    tooltips="quitar todos los adjuntos"
                                    @click="currentMessage.attachments = []"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>adjuntos actuales</q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-separator></q-separator>
                        <q-item
                            v-for="(f, index) in currentMessage.attachments"
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
                                        currentMessage.attachments.splice(
                                            index,
                                            1
                                        )
                                    "
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>{{ f.name }}</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-list>
                    <checkbox-field
                        name="add_attachments"
                        label="agregar adjuntos"
                        v-model="addAttachments"
                        :modelValue="addAttachments"
                        @update="
                            (name, val) => {
                                addAttachments = val;
                                totalFiles = 0;
                            }
                        "
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
                        @change-files="
                            (files) => {
                                totalFiles = files;
                            }
                        "
                        @finish="onFinishUploaded"
                        v-if="addAttachments"
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
import { onMounted, ref, watch } from "vue";
import FormChatComponent from "./FormChatComponent.vue";
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnSaveComponent from "../../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import UploaderField from "../../../form/input/UploaderField.vue";
import EditorField from "../../../form/input/EditorField.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import { useForm, router } from "@inertiajs/vue3";
import { Dark } from "quasar";
import { Loading } from "quasar";
import axios from "axios";
import { success } from "../../../../helpers/notifications";

defineOptions({
    name: "ChatActionsComponent",
});

const props = defineProps({
    message: Object,
    topic: Object,
});

const emits = defineEmits(["hide-menu"]);

const menu = ref(null);
const maximizedToggle = ref(false);
const showDialog = ref(false);
const confirm = ref(false);
const formData = useForm({
    id: null,
    message: null,
});
const upload = ref(false);
const form = ref(null);
const currentMessage = ref(null);
const totalFiles = ref(0);
const addAttachments = ref(false);
onMounted(() => {
    currentMessage.value = props.message;
});

watch(
    () => props.message,
    (n) => {
        currentMessage.value = n;
    },
    { deep: true }
);

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const reactHighligthDelete = async (action) => {
    const send = useForm({});
    const url = `/admin/schooltopics/${action}-message/${currentMessage.value.id}`;
    if (action === "delete") send.delete(url);
    else send.post(url);
};

const onFinishUploaded = (info) => {
    success("mensaje editado correctamente");
    Loading.hide();
    showDialog.value = false;
    upload.value = false;
    router.reload({}, "preserveState");
};

const save = async () => {
    form.value.validate().then(async (success) => {
        if (success) {
            Loading.show();
            const { message } = formData;
            const currentAttachments = currentMessage.value.attachments.map(
                (m) => m.id
            );
            await axios
                .post(
                    `/admin/schooltopics/edit-message/${currentMessage.value.id}`,
                    {
                        message,
                        currentAttachments,
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

const onShow = () => {
    formData.id = currentMessage.value.id;
    formData.message = currentMessage.value.message;
};

const onHide = () => {
    formData.message = null;
    maximizedToggle.value = false;
    totalFiles.value = 0;
    upload.value = false;
    addAttachments.value = false;
    menu.value.hide();
};
</script>
