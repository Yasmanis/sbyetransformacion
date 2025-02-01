<template>
    <q-btn-component
        icon="mdi-message-plus-outline"
        :tooltips="!showListUser ? 'responder mensaje' : 'escribir mensaje'"
        @click="showDialog = true"
    />
    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        @show="onShowDialog"
        @hide="emits('hide')"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-message-plus-outline"
                :title="
                    !showListUser
                        ? 'responder mensaje privado'
                        : 'escribir mensaje privado'
                "
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                {{ user }}
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <users-select-dialog-component
                        label="destinatarios"
                        name="users"
                        :required="true"
                        @update="
                            (n, v) =>
                                onUpdateField(
                                    n,
                                    v && v.length > 0
                                        ? v.map((u) => u.value)
                                        : null
                                )
                        "
                        v-if="showListUser"
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
                        v-model="formData.msg"
                        :modelValue="formData.msg"
                        :othersProps="{
                            required: true,
                        }"
                        name="msg"
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
    showListUser: {
        type: Boolean,
        default: true,
    },
    user: Number,
    parent: Number,
    title: String,
    enter_image: String,
    leave_image: String,
    tooltips: String,
    size: String,
    padding: String,
});

const emits = defineEmits(["hide"]);

const showDialog = ref(false);
const help = ref(null);
const helpEdit = ref(false);
const formData = useForm({
    title: null,
    msg: null,
    attachments: [],
    users: null,
    parent_id: null,
    to_id: null,
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

const onShowDialog = () => {
    // formData.users = props.user ? [props.user] : null;
    // formData.parent_id = props.parent ? props.parent : null;
    // formData.to_id = props.user ? props.user : null;
};

const save = async () => {
    form.value.validate().then(async (success) => {
        if (success) {
            formData.post("/admin/private-message", {
                onSuccess: () => {
                    formData.reset();
                    showDialog.value = false;
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
