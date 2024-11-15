<template>
    <q-separator class="q-mt-lg q-mb-sm" v-if="btnDelete" />
    <name-component
        v-model="model"
        :label="label"
        :name="name"
        :othersProps="{
            required: true,
        }"
        :modelValue="topic.name"
        :btnDelete="btnDelete"
        @update="
            (name, val) => {
                current.name = val;
            }
        "
        @remove="onRemove"
    />
    <div class="row q-mt-md q-ml-none">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0px">
            <cover-image-component
                :src="current.src"
                @change="
                    (img) => {
                        current.coverImage = img;
                    }
                "
            />
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div
                class="row"
                :class="screen.xs || screen.sm ? 'q-mt-sm' : 'q-ml-md'"
            >
                <uploader-field
                    label="video principal"
                    :multiple="false"
                    :formFields="[
                        {
                            name: 'id',
                            value: current.id,
                        },
                        {
                            name: 'principal',
                            value: 1,
                        },
                    ]"
                    :upload="upload"
                    accept="video/*"
                    url="/admin/schooltopics/addResources"
                    @uploaded="onUploaded"
                    @change-files="
                        (files) => {
                            current.principalVideo = files > 0;
                        }
                    "
                    @finish="(info, principal) => onFinishUploaded(info, true)"
                />
            </div>
            <div
                class="row q-mt-sm"
                :class="screen.xs || screen.sm ? '' : 'q-ml-md'"
            >
                <uploader-field
                    label="adjuntos"
                    :formFields="[
                        {
                            name: 'id',
                            value: current.id,
                        },
                        {
                            name: 'principal',
                            value: 0,
                        },
                    ]"
                    :upload="upload"
                    :noThumbnails="true"
                    url="/admin/schooltopics/addResources"
                    @uploaded="onUploaded"
                    @change-files="
                        (files) => {
                            totalFiles = files;
                        }
                    "
                    @finish="(info, principal) => onFinishUploaded(info, false)"
                />
            </div>
        </div>
    </div>
    <checkbox-field
        v-model="current.descriptionAdd"
        label="añadir descripcion"
        name="add_description"
        :modelValue="current.description"
        class="q-ml-none q-mt-sm"
        @update="
            (name, val) => {
                current.descriptionAdd = val;
            }
        "
    />

    <editor-field
        v-model="current.description"
        name="description"
        :rows="3"
        :modelValue="current.description"
        :othersProps="{
            required: true,
        }"
        @update="
            (name, val) => {
                current.description = val;
            }
        "
        v-if="current.descriptionAdd"
    />
</template>

<script setup>
import { onBeforeMount, ref, watch, computed, onUpdated } from "vue";
import NameComponent from "./NameComponent.vue";
import CoverImageComponent from "./CoverImageComponent.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import EditorField from "../../../form/input/EditorField.vue";
import UploaderField from "../../../form/input/UploaderField.vue";
import axios from "axios";
import { useQuasar } from "quasar";

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

const emits = defineEmits(["add", "update", "remove", "change-files", "save"]);

const model = ref(null);
const current = ref(null);
const upload = ref(false);
const totalFiles = ref(0);
const finishVideo = ref(false);
const finishResources = ref(false);

onBeforeMount(() => {
    model.value = props.topic.name;
    current.value = props.topic;
});

watch(
    () => props.save,
    (n, o) => {
        if (n) saveTopic();
    }
);

const screen = computed(() => {
    return $q.screen;
});

const onRemove = () => {
    emits("remove");
};

const saveTopic = async () => {
    let { name, coverImage, description, section_id } = current.value;
    await axios
        .post(
            "/admin/schooltopics",
            { name, coverImage, description, section_id },
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        )
        .then((response) => {
            current.value.id = response.data.id;
            setTimeout(() => {
                upload.value = true;
            }, 1000);
            if (!current.value.principalVideo && totalFiles.value === 0) {
                emits("save", {
                    uploaded: 0,
                    failed: 0,
                    total: 0,
                });
            }
        })
        .catch(() => {});
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
        (!current.value.principalVideo && finishResources.value) ||
        (finishVideo.value && totalFiles.value === 0)
    ) {
        emits("save", info);
    }
};
</script>
