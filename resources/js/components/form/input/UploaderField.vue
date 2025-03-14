<template>
    <q-uploader
        ref="uploader"
        class="full-width"
        :class="class"
        :field-name="name"
        :label="label"
        :name="name"
        :url="url"
        :form-fields="formFields"
        :color="color"
        :accept="accept"
        :no-thumbnails="noThumbnails"
        hide-upload-btn
        :multiple="multiple"
        @failed="onFailed"
        @finish="onFinish"
        @rejected="onRejected"
        @uploaded="onUploaded"
        @added="onAdeded"
        @removed="onRemoved"
    >
        <template v-slot:header="scope">
            <div class="row no-wrap items-center q-pa-sm q-gutter-xs">
                <q-btn
                    v-if="scope.queuedFiles.length > 0"
                    icon="clear_all"
                    @click="scope.removeQueuedFiles"
                    round
                    dense
                    flat
                >
                    <q-tooltip>limpiar</q-tooltip>
                </q-btn>
                <q-btn
                    v-if="scope.uploadedFiles.length > 0"
                    icon="done_all"
                    @click="scope.removeUploadedFiles"
                    round
                    dense
                    flat
                >
                    <q-tooltip>eliminar ficheros subidos</q-tooltip>
                </q-btn>
                <q-spinner
                    v-if="scope.isUploading"
                    class="q-uploader__spinner"
                />
                <div class="col">
                    <div class="q-uploader__title">{{ label }}</div>
                    <div class="q-uploader__subtitle">
                        {{ scope.uploadSizeLabel }} /
                        {{ scope.uploadProgressLabel }}
                    </div>
                </div>
                <q-btn
                    v-if="scope.canAddFiles"
                    type="a"
                    icon="add_box"
                    @click="scope.pickFiles"
                    round
                    dense
                    flat
                >
                    <q-uploader-add-trigger />
                    <q-tooltip>adicionar</q-tooltip>
                </q-btn>
                <q-btn
                    v-if="changeFromTopic"
                    icon="close"
                    @click="onCancel"
                    round
                    dense
                    flat
                >
                    <q-tooltip>cancelar</q-tooltip>
                </q-btn>

                <q-btn
                    v-if="scope.isUploading"
                    icon="clear"
                    @click="scope.abort"
                    round
                    dense
                    flat
                >
                    <q-tooltip>abortar</q-tooltip>
                </q-btn>
            </div>
        </template>
    </q-uploader>
    <div
        class="q-field__bottom row items-start q-field__bottom--stale"
        style="padding-left: 0px"
        v-if="required"
    >
        <div class="q-field__messages col">
            <ul style="padding: 0px; margin-top: 0px; margin-bottom: 0px">
                <li
                    class="text-help"
                    :style="{
                        'list-style': 'none',
                        color: color === 'red' ? 'red' : '',
                    }"
                >
                    requerido
                </li>
            </ul>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onBeforeMount, watch } from "vue";
import { validations } from "../../../helpers/validations";
import { error } from "../../../helpers/notifications";

defineOptions({
    name: "UploaderField",
});

const props = defineProps({
    accept: String,
    class: String,
    modelValue: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
        default: "file",
    },
    label: {
        type: String,
        default: "",
    },
    leftLabel: {
        type: Boolean,
        default: false,
    },
    dense: {
        type: Boolean,
        default: false,
    },
    noThumbnails: {
        type: Boolean,
        default: false,
    },
    url: {
        type: String,
        default: "/admin/files",
    },
    formFields: {
        type: Array,
        default: () => [],
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    upload: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
    multiple: {
        type: Boolean,
        default: true,
    },
    errorWhenEmpty: {
        type: Boolean,
        default: true,
    },
    changeFromTopic: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits([
    "uploaded",
    "uploading",
    "finish",
    "change-files",
    "cancel",
]);

const model = ref(false);
const uploader = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);
const uploaded = ref(0);
const failed = ref(0);
const color = ref("primary");
const countFiles = ref(0);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

onMounted(() => {
    model.value = props.modelValue;
});

watch(
    () => props.upload,
    (n) => {
        if (n) {
            if (countFiles.value > 0) {
                color.value = "primary";
                uploader.value.upload();
            } else {
                if (props.errorWhenEmpty) {
                    error("al menos debe seleccionar un fichero");
                }
            }
            emits("uploading");
        }
    }
);

const onFinish = () => {
    if (failed.value === 0) {
        emits("uploaded");
    }
    emits("finish", {
        uploaded: uploaded.value,
        failed: failed.value,
        total: uploaded.value + failed.value,
    });
    failed.value = 0;
    uploaded.value = 0;
};

const onFailed = (info) => {
    failed.value++;
};

const onRejected = (info) => {
    error("fichero(s) no admitido(s)");
};

const onUploaded = (info) => {
    uploaded.value++;
    countFiles.value -= 1;
};

const onAdeded = (files) => {
    countFiles.value += files.length;
    emits("change-files", countFiles.value);
};

const onRemoved = (files) => {
    countFiles.value -= files.length;
    emits("change-files", countFiles.value);
};

const onCancel = () => {
    emits("cancel");
};
</script>
<style scope>
.body--dark .text-help {
    color: rgba(255, 255, 255, 0.7);
}
</style>
