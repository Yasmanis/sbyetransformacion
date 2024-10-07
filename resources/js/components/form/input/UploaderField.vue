<template>
    <q-uploader
        ref="uploader"
        field-name="file"
        :label="label"
        :name="name"
        :url="url"
        :form-fields="formFields"
        :color="color"
        hide-upload-btn
        multiple
        @failed="onFailed"
        @finish="onFinish"
        @factory-failed="onFactoryFailed"
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
    modelValue: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
        required: true,
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
});

const emits = defineEmits(["uploaded", "uploading"]);

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
    failed.value = 0;
    uploaded.value = 0;
};

const onFailed = (info) => {
    failed.value++;
};

const onRejected = (info) => {
    console.log("onRejected");
};

const onUploaded = (info) => {
    uploaded.value++;
    countFiles.value -= 1;
};

const onAdeded = (files) => {
    countFiles.value += files.length;
};

const onRemoved = (files) => {
    countFiles.value -= files.length;
};
</script>
<style scope>
.body--dark .text-help {
    color: rgba(255, 255, 255, 0.7);
}
</style>
