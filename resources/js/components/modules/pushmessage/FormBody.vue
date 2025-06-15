<template>
    <q-card-section class="col q-pt-none">
        <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
            <div
                class="form-field"
                v-for="(f, index) in fields"
                :key="`field-${index}`"
            >
                <text-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-if="f.type === 'text'"
                />
                <editor-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-else-if="f.type === 'editor'"
                />
                <file-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-else-if="f.type === 'file'"
                />
                <hidden-field
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    v-else-if="f.type === 'hidden'"
                />
                <users-select-dialog-component
                    :name="f.name"
                    :label="f.label"
                    :multiple="f.multiple"
                    :required="f.required"
                    :model-value="formData[f.name]"
                    @update="onUpdateUsers"
                    v-else-if="f.type === 'users'"
                />
                <campaign-field
                    :label="f.label"
                    :name="f.name"
                    :campaign="formData['campaign_id']"
                    :sections="formData['sections_id']"
                    @update="onUpdateField"
                    v-else-if="f.type === 'campaign'"
                />
                <periodicity-field
                    :name="f.name"
                    :label="f.label"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-else-if="f.type === 'periodicity'"
                />
                <checkbox-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'boolean'"
                />
                <uploader-field
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'uploader'"
                />
                <select-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    :options="f.options"
                    :othersProps="f.othersProps"
                    :filterable="f.filterable"
                    :multiple="f?.othersProps?.multiple ?? false"
                    @update="onUpdateField"
                    v-else-if="f.type === 'select'"
                />
                <date-field
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name]"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'date'"
                />
                <date-time-range-field
                    :start-name="f.startName"
                    :end-name="f.endName"
                    :start-label="f.startLabel"
                    :end-label="f.endLabel"
                    :start-value="formData[f.startName]"
                    :end-value="formData[f.endName]"
                    :others-start-props="f.othersStartProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'datetimerangefield'"
                />
                <password-field
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    @confirm="onUpdateField"
                    v-else-if="f.type === 'password'"
                />
            </div>
        </q-form>
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
        <q-btn-component
            icon="mdi-eye-outline"
            tooltips="vista previa"
            :disable="disablePreviewBtn"
            :loading="loadingPreviewBtn"
            @click="emits('show-preview', formData)"
        />
        <btn-save-component @click="save(true)" />
        <btn-save-and-new-component
            @click="save(false)"
            v-if="!object && newOnCreate"
        />
        <btn-cancel-component :cancel="true" @click="emits('cancel')" />
    </q-card-actions>
</template>

<script setup>
defineOptions({
    name: "FormBody",
});

import { ref, onBeforeMount, watch } from "vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import DateField from "../../form/input/DateField.vue";
import DateTimeRangeField from "../../form/input/DateTimeRangeField.vue";
import PasswordField from "../../form/input/PasswordField.vue";
import UploaderField from "../../form/input/UploaderField.vue";
import EditorField from "../../form/input/EditorField.vue";
import FileField from "../../form/input/FileField.vue";
import HiddenField from "../../form/input/HiddenField.vue";
import CampaignField from "../../form/input/CampaignField.vue";
import PeriodicityField from "../../form/input/PeriodicityField.vue";
import UsersSelectDialogComponent from "../../modules/user/UsersSelectDialogComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../../btn/BtnSaveAndNewComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../../helpers/notifications";

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
    postOnUpdate: {
        type: Boolean,
        default: false,
    },
    newOnCreate: {
        type: Boolean,
        default: true,
    },
    duplicate: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["created", "updated", "cancel", "show-preview"]);

const form = ref(null);
const disablePreviewBtn = ref(false);
const loadingPreviewBtn = ref(false);
const formData = ref({});

onBeforeMount(() => {
    formData.value["duplicated"] = props.duplicate ? 1 : 0;
    setDefaultData();
});

const setDefaultData = () => {
    props.fields.forEach((f) => {
        if (f.type === "boolean") {
            formData.value[f.name] = props.object
                ? props.object[f.name]
                : false;
        } else if (f.type === "datetimerangefield") {
            formData.value[f.startName] = props.object
                ? props.object[f.startName]
                : null;
            formData.value[f.endName] = props.object
                ? props.object[f.endName]
                : null;
        } else if (f.type === "select") {
            formData.value[f.name] = props.object ? props.object[f.name] : null;
        } else if (f.type === "campaign") {
            formData.value["campaign_id"] = props.object
                ? props.object["campaign_id"]
                : null;
            formData.value["sections_id"] = props.object
                ? props.object["sections_id"]
                : null;
        } else if (f.type === "users") {
            let users = [];
            let selected = props.object
                ? props.object[`${f.name}_object`]
                : null;
            if (selected !== null && selected != undefined) {
                selected = props.object[`${f.name}_object`];
                if (Array.isArray(selected)) {
                    selected.forEach((u) => {
                        users.push({
                            value: u.id,
                            label: u.full_name,
                        });
                    });
                } else {
                    users.push({
                        value: selected.id,
                        label: selected.full_name,
                    });
                }
            }
            formData.value[f.name] = users;
        } else {
            formData.value[f.name] = props.object
                ? props.object[f.name]
                : f.othersProps && f.othersProps.defaultValue
                ? f.othersProps.defaultValue
                : null;
        }
    });
};

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const onUpdateUsers = (name, val) => {
    formData.value[name] = val.map((v) => v.value);
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (!props.object || props.duplicate) {
                store(hide);
            } else {
                update();
            }
        } else {
            errorValidation();
        }
    });
};

const store = async (hide) => {
    const send = useForm(formData.value);
    send.post(props.module.base_url, {
        onSuccess: (data) => {
            setDefaultData();
            emits("created", data.props.object, hide);
        },
    });
};

const update = async () => {
    if (props.postOnUpdate) {
        formData.value["_method"] = "put";
        const send = useForm(formData.value);
        send.post(`${props.module.base_url}/${props.object.id}`, {
            onSuccess: (data) => {
                setDefaultData();
                emits("updated", data.props.object);
            },
        });
    } else {
        const send = useForm(formData.value);
        send.put(`${props.module.base_url}/${props.object.id}`, {
            onSuccess: (data) => {
                setDefaultData();
                emits("updated", data.props.object);
            },
        });
    }
};

const disablePreview = (val) => {
    disablePreviewBtn.value = val;
};

const loadingPreview = (val) => {
    loadingPreviewBtn.value = val;
};

defineExpose({ disablePreview, loadingPreview });
</script>
