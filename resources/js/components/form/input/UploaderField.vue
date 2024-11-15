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
    />
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
});

const emits = defineEmits(["uploaded", "uploading", "finish", "change-files"]);

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
                error("al menos debe seleccionar un fichero");
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
</script>
<style scope>
.body--dark .text-help {
    color: rgba(255, 255, 255, 0.7);
}
</style>
