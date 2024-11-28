<template>
    <q-separator class="q-mt-lg q-mb-sm" v-if="btnDelete" />
    <name-component
        v-model="formData.name"
        :label="label"
        :name="name"
        :othersProps="{
            required: true,
        }"
        :modelValue="formData.name"
        :btnDelete="btnDelete"
        @update="
            (name, val) => {
                formData.name = val;
            }
        "
        @remove="onRemove"
    />
    <div class="row q-mt-md q-ml-none">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0px">
            <cover-image-component
                :src="
                    formData.coverImage
                        ? `${$page.props.public_path}storage/${formData.coverImage}`
                        : null
                "
                @change="
                    (img) => {
                        formData.coverImage = img;
                        isOk();
                    }
                "
            />
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div
                class="row"
                :class="screen.xs || screen.sm ? 'q-mt-sm' : 'q-ml-md'"
            >
                <q-list
                    dense
                    class="full-width"
                    v-if="ppalVideo && !changePrincipalVideo"
                >
                    <q-item style="padding: 2px 0px">
                        <q-item-section avatar>
                            <q-icon name="mdi-video" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label lines="1">
                                {{ ppalVideo.name }}
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-edit-component
                                tooltips="cambiar video principal"
                                @click="changePrincipalVideo = true"
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-delete-component
                                tooltips="eliminar video principal"
                                @click="onRemoveAttachment(ppalVideo)"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
                <div
                    class="row full-width"
                    :class="screen.xs || screen.sm ? '' : 'q-ml-md'"
                    v-if="!ppalVideo || changePrincipalVideo"
                >
                    <uploader-field
                        :label="
                            changePrincipalVideo
                                ? 'cambiar video principal'
                                : 'video principal'
                        "
                        :multiple="false"
                        :formFields="[
                            {
                                name: 'id',
                                value: formData.id,
                            },
                            {
                                name: 'principal',
                                value: 1,
                            },
                        ]"
                        :upload="upload"
                        :errorWhenEmpty="false"
                        :changeFromTopic="changePrincipalVideo"
                        accept="video/*"
                        url="/admin/schooltopics/addResources"
                        @uploaded="onUploaded"
                        @change-files="
                            (files) => {
                                formData.principalVideo = files > 0;
                                isOk();
                            }
                        "
                        @finish="
                            (info, principal) => onFinishUploaded(info, true)
                        "
                        @cancel="changePrincipalVideo = false"
                    />
                </div>
                <q-list
                    dense
                    class="full-width"
                    :class="!ppalVideo || changePrincipalVideo ? 'q-mt-sm' : ''"
                    v-if="attachments.length > 0 || topic.id !== null"
                >
                    <q-item
                        style="padding: 2px 0px"
                        v-for="(r, index) in attachments"
                        :key="`index-resource-${index}`"
                    >
                        <q-item-section avatar>
                            <q-icon name="mdi-attachment fa-rotate-90" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label lines="1">
                                {{ r.name }}
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-delete-component
                                tooltips="eliminar adjunto"
                                @click="onRemoveAttachment(r)"
                            />
                        </q-item-section>
                    </q-item>
                    <q-item
                        style="padding: 2px 0px"
                        v-if="attachments.length !== 0 && !addNewAttachments"
                    >
                        <q-item-section avatar>
                            <btn-add-component
                                tooltips="adicionar adjuntos"
                                @click="addNewAttachments = true"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
            <div
                class="row q-mt-sm"
                :class="screen.xs || screen.sm ? '' : 'q-ml-md'"
                v-if="attachments.length === 0 || addNewAttachments"
            >
                <uploader-field
                    label="adjuntos"
                    :formFields="[
                        {
                            name: 'id',
                            value: formData.id,
                        },
                        {
                            name: 'principal',
                            value: 0,
                        },
                    ]"
                    :upload="upload"
                    :noThumbnails="true"
                    :errorWhenEmpty="false"
                    :changeFromTopic="addNewAttachments"
                    url="/admin/schooltopics/addResources"
                    @uploaded="onUploaded"
                    @change-files="
                        (files) => {
                            totalFiles = files;
                        }
                    "
                    @finish="(info, principal) => onFinishUploaded(info, false)"
                    @cancel="addNewAttachments = false"
                />
            </div>
        </div>
    </div>
    <checkbox-field
        v-model="addDescription"
        label="añadir descripcion"
        name="add_description"
        class="q-ml-none q-mt-sm"
        :modelValue="addDescription"
        @update="
            (name, val) => {
                addDescription = val;
                formData.description = null;
            }
        "
    />

    <editor-field
        v-model="formData.description"
        name="description"
        :rows="3"
        :modelValue="formData.description"
        :othersProps="{
            required: true,
        }"
        @update="
            (name, val) => {
                formData.description = val;
            }
        "
        v-if="addDescription"
    />
</template>

<script setup>
import { onBeforeMount, ref, watch, computed, onUpdated } from "vue";
import NameComponent from "./NameComponent.vue";
import CoverImageComponent from "./CoverImageComponent.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import EditorField from "../../../form/input/EditorField.vue";
import UploaderField from "../../../form/input/UploaderField.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import BtnAddComponent from "../../../btn/BtnAddComponent.vue";
import axios from "axios";
import { Loading, useQuasar, Notify } from "quasar";
import { useForm } from "@inertiajs/vue3";

defineOptions({
    name: "TopicComponent",
});

const props = defineProps({
    topic: {
        type: Object,
        default: () => ({}),
    },
    label: {
        type: String,
        default: "tema",
    },
    name: {
        type: String,
        default: "name",
    },
    btnDelete: {
        type: Boolean,
        default: false,
    },
    save: {
        type: Boolean,
        default: false,
    },
});

const $q = useQuasar();

const emits = defineEmits([
    "add",
    "update",
    "remove",
    "change-files",
    "save",
    "is-ok",
]);

const upload = ref(false);
const totalFiles = ref(0);
const finishVideo = ref(false);
const finishResources = ref(false);
const addNewAttachments = ref(false);
const changePrincipalVideo = ref(false);
const formData = ref({});
const ppalVideo = ref(null);
const addDescription = ref(false);
const attachments = ref([]);

onBeforeMount(() => {
    let { id, name, description, coverImage, section_id } = props.topic;
    let resources = props.topic.resources;
    ppalVideo.value = resources.find((r) => r.principal);
    formData.value = {
        id,
        name,
        description,
        coverImage,
        section_id,
        principalVideo: false,
    };
    addDescription.value =
        props.topic && props.topic.description !== null ? true : false;
    attachments.value = resources.filter((r) => !r.principal);
});

watch(
    () => props.save,
    (n, o) => {
        if (n) {
            if (formData.value.id !== null) update();
            else {
                formData.value.section_id = props.topic.section_id;
                store();
            }
        }
    }
);

const screen = computed(() => {
    return $q.screen;
});

const isOk = () => {
    emits(
        "is-ok",
        formData.value.principalVideo && formData.value.coverImage !== null
    );
};

const onRemove = () => {
    emits("remove");
};

const store = async () => {
    await axios
        .post("/admin/schooltopics", formData.value, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            formData.value.id = response.data.id;
            setTimeout(() => {
                upload.value = true;
            }, 1000);
            if (!formData.value.principalVideo && totalFiles.value === 0) {
                emits(
                    "save",
                    {
                        uploaded: 0,
                        failed: 0,
                        total: 0,
                    },
                    true
                );
            }
        })
        .catch(() => {});
};

const update = async () => {
    let { name, description, coverImage } = formData.value;
    const send = useForm({
        name,
        description,
        coverImage,
        _method: "put",
        excludeFlash: totalFiles.value > 0 || formData.value.principalVideo,
    });
    send.post(`/admin/schooltopics/${formData.value.id}`, {
        onSuccess: () => {
            if (totalFiles.value === 0 && !formData.value.principalVideo) {
                emits("update");
            } else {
                upload.value = true;
            }
        },
        onError: () => {
            emits("error");
        },
    });
};

const onUploaded = () => {};

const onFinishUploaded = (info, principal) => {
    if (principal) {
        finishVideo.value = true;
    } else {
        finishResources.value = true;
    }
    if (
        (finishVideo.value && finishResources.value) ||
        (!formData.value.principalVideo && finishResources.value) ||
        (finishVideo.value && totalFiles.value === 0)
    ) {
        emits("save", info, formData.value.id === null);
    }
};

const onRemoveAttachment = (attachment) => {
    $q.dialog({
        title: "confirmacion",
        html: true,
        message: `seguro que deseas eliminar ${
            attachment.principal ? "el video principal" : "este adjunto"
        }`,
        cancel: {
            label: "cancelar",
            icon: "mdi-cancel",
        },
        ok: {
            label: "si",
            icon: "mdi-check",
            color: "red",
        },
        persistent: true,
    }).onOk(() => {
        const send = useForm({});
        send.delete(`/admin/schooltopics/deleteResource/${attachment.id}`, {
            onSuccess: () => {
                if (attachment.principal) {
                    ppalVideo.value = null;
                } else {
                    attachments.value = attachments.value.filter(
                        (r) => r.id !== attachment.id
                    );
                }
            },
        });
    });
};
</script>
