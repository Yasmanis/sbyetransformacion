<template>
    <q-card-section class="col q-pt-none">
        <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
            <div class="form-field">
                <text-field
                    v-model="formData['name']"
                    label="titulo"
                    name="name"
                    :othersProps="{
                        required: true,
                    }"
                    :modelValue="formData['name']"
                    @update="onUpdateField"
                />
                <select-field
                    label="tipo"
                    name="type"
                    :modelValue="formData['type']"
                    :options="[
                        {
                            label: 'texto',
                            value: 'text',
                        },
                        {
                            label: 'video',
                            value: 'video',
                        },
                    ]"
                    :othersProps="{
                        required: true,
                    }"
                    :filterable="false"
                    @update="onUpdateField"
                />
                <editor-field
                    :model-value="formData['message']"
                    label="mensaje"
                    name="message"
                    :othersProps="{
                        required: !user.admin,
                    }"
                    @update="onUpdateField"
                    v-if="formData['type'] === 'text'"
                />
                <file-field
                    label="mensaje"
                    name="message"
                    :othersProps="{ required: !user.admin, accept: 'video/*' }"
                    :modelValue="formData['message']"
                    @update="onUpdateField"
                    v-if="formData['type'] === 'video'"
                />
                <users-select-dialog-component
                    name="user_id"
                    label="usuario"
                    icon="mdi-account-outline"
                    :multiple="false"
                    :required="true"
                    :show-label-when-selected="false"
                    :model-value="formData.user_id"
                    @update="onUpdateField"
                    v-if="user.admin && !excludeUser"
                />

                <select-field
                    label="tomo"
                    name="book_volume"
                    :modelValue="formData['book_volume']"
                    :options="currentVolumes"
                    :filterable="false"
                    :disable="currentVolumes.length === 0"
                    :othersProps="{
                        required: !user.admin,
                    }"
                    @update="onUpdateField"
                />
                <text-field
                    v-model="formData['msg_to_admin']"
                    label="mensaje al admin"
                    name="msg_to_admin"
                    type="textarea"
                    :autogrow="true"
                    :modelValue="formData['msg_to_admin']"
                    @update="onUpdateField"
                />
                <file-field
                    v-model="formData['amazon_image']"
                    label="imagen del testimonio de amazon"
                    name="amazon_image"
                    :othersProps="{
                        accept: 'image/*',
                        icon: 'mdi-image-outline',
                    }"
                    :modelValue="formData['amazon_image']"
                    @update="onUpdateField"
                />
                <text-field
                    v-model="formData['name_to_show']"
                    label="nombre a mostrar"
                    name="name_to_show"
                    :modelValue="formData['name_to_show']"
                    @update="onUpdateField"
                />
                <checkbox-field
                    label="marca esta casilla si quieres hacer un testimonio anonimo, aunque es preferible que utilices un pseudonimo o solo tu nombre o diminutivo"
                    name="anonimous"
                    class="q-mt-sm"
                    :modelValue="formData['anonimous']"
                    @update="onUpdateField"
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

import { ref, onBeforeMount } from "vue";
import TextField from "../../form/input/TextField.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import SelectField from "../../form/input/SelectField.vue";
import FileField from "../../form/input/FileField.vue";
import EditorField from "../../form/input/EditorField.vue";
import SelectUsers from "../../form/input/SelectUsers.vue";
import UsersSelectDialogComponent from "../user/UsersSelectDialogComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";
import { Loading, Dark } from "quasar";
import axios from "axios";

const props = defineProps({
    module: {
        type: Object,
        default: () => {},
    },
    object: {
        type: Object,
        default: null,
    },
    fields: {
        type: Array,
        default: () => [],
    },
    excludeUser: Boolean,
    postOnUpdate: Boolean,
    axiosRequest: Boolean,
});

const emits = defineEmits(["created", "updated", "cancel"]);

const form = ref(null);

const formData = ref({});

const currentVolumes = ref([]);
const volumesStr = {
    tomo_1: "tomo I",
    tomo_2: "tomo II",
    tomo_3: "tomo III",
};

const page = usePage();

onBeforeMount(() => {
    setDefaultData();
});

const user = page.props.auth.user;

const setDefaultData = () => {
    const object = props.object;
    formData.value["type"] = object?.file_type ?? null;
    formData.value.name_to_show = object?.name_to_show ?? null;
    formData.value.anonimous = object?.anonimous ?? false;
    formData.value.name = object?.name ?? null;
    formData.value.message = object?.message ?? null;
    formData.value.msg_to_admin = object?.msg_to_admin ?? null;
    formData.value.amazon_image = object?.amazon_image ?? null;
    formData.value.user_id = object?.user_id ?? null;
    formData.value.book_volume = object?.book_volume ?? null;
    if (object) {
        setVolumes(object.volumes);
    } else {
        formData.value.user_id = user.id;
        setVolumes(user.book_volumes);
    }
};

const onUpdateField = (name, val, full) => {
    formData.value[name] = val;
    if (name === "user_id") {
        formData.value.book_volume = null;
        setVolumes(val ? full?.volumes : null);
    } else if (name === "type") {
        formData.value.message = null;
    }
};

const setVolumes = (volumes) => {
    currentVolumes.value = [];
    if (volumes) {
        volumes.forEach((v) => {
            currentVolumes.value.push({
                label: volumesStr[v],
                value: v,
            });
        });
    }
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (formData.value.type === "text" && !formData.value.message) {
                error("debe especificar el mensaje");
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
    if (props.axiosRequest) {
        saveAxiosRequest(props.module.base_url, "post", hide);
    } else {
        const send = useForm(formData.value);
        send.post(props.module.base_url, {
            onSuccess: (data) => {
                setDefaultData();
                emits("created", data.props.object, hide);
            },
        });
    }
};

const update = async () => {
    if (props.axiosRequest) {
        saveAxiosRequest(
            `${props.module.base_url}/${props.object.id}`,
            "patch",
            true,
        );
    } else {
        const send = useForm(formData.value);
        send.post(`${props.module.base_url}/${props.object.id}`, {
            onSuccess: (data) => {
                setDefaultData();
                emits("updated", data.props.object);
            },
        });
    }
};

const saveAxiosRequest = async (url, method, hide) => {
    Loading.show();
    const fr = new FormData();
    Object.keys(formData.value).forEach((k) => {
        fr.append(k, formData.value[k] ?? "");
    });
    await axios
        .post(url, fr, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((res) => {
            const data = res.data;
            if (data.success) {
                success(data.message);
                setDefaultData();
                emits(
                    method === "post" ? "created" : "updated",
                    data.object,
                    hide,
                );
            }
        })
        .finally(() => {
            Loading.hide();
        });
};
</script>
