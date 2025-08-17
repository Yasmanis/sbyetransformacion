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
                    :autogrow="f.autogrow ?? false"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-if="f.type === 'text'"
                />
                <number-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @update="onUpdateField"
                    v-if="f.type === 'number'"
                />
                <rating-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :modelValue="formData[f.name] ?? 0"
                    :othersProps="f.othersProps"
                    @update="onUpdateField"
                    v-if="f.type === 'rating'"
                />
                <image-field
                    v-model="formData[f.name]"
                    :label="f.label"
                    :name="f.name"
                    :othersProps="f.othersProps"
                    :modelValue="formData[f.name]"
                    @change="onUpdateField"
                    v-if="f.type === 'image'"
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
                <subtitle-field
                    :label="f.label"
                    :name="f.name"
                    :objects="formData[f.name]"
                    :parent="formData"
                    @remove="
                        (id) =>
                            (formData[f.name] = formData[f.name].filter(
                                (s) => s.id !== id
                            ))
                    "
                    v-else-if="f.type === 'subtitles'"
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
                <state-field
                    :country="f.country"
                    :state="f.state"
                    @update="onUpdateField"
                    v-else-if="f.type === 'state'"
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
                <date-range-field
                    :start-name="f.startName"
                    :end-name="f.endName"
                    :start-label="f.startLabel"
                    :end-label="f.endLabel"
                    :start-value="formData[f.startName]"
                    :end-value="formData[f.endName]"
                    :others-props="f.othersProps"
                    @update="onUpdateField"
                    v-else-if="f.type === 'daterange'"
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

import { ref, onBeforeMount } from "vue";
import TextField from "./input/TextField.vue";
import NumberField from "./input/NumberField.vue";
import ImageField from "./input/ImageField.vue";
import SelectField from "./input/SelectField.vue";
import CheckboxField from "./input/CheckboxField.vue";
import DateField from "./input/DateField.vue";
import DateRangeField from "./input/DateRangeField.vue";
import DateTimeRangeField from "./input/DateTimeRangeField.vue";
import PasswordField from "./input/PasswordField.vue";
import UploaderField from "./input/UploaderField.vue";
import EditorField from "./input/EditorField.vue";
import FileField from "./input/FileField.vue";
import HiddenField from "./input/HiddenField.vue";
import CampaignField from "./input/CampaignField.vue";
import PeriodicityField from "./input/PeriodicityField.vue";
import StateField from "./input/StateField.vue";
import RatingField from "./input/RatingField.vue";
import UsersSelectDialogComponent from "../modules/user/UsersSelectDialogComponent.vue";
import SubtitleField from "./input/SubtitleField.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../btn/BtnSaveAndNewComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation, success } from "../../helpers/notifications";
import axios from "axios";
import { Loading } from "quasar";

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
    axiosRequest: Boolean,
});

const emits = defineEmits(["created", "updated", "cancel"]);

const form = ref(null);

const formData = ref({});

onBeforeMount(() => {
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
        } else if (f.type === "state") {
            let country = {
                name: f.country?.name ?? "country_id",
                label: f.country?.label ?? "pais",
                modelValue: null,
                othersProps: f.country?.othersProps ?? null,
            };
            let state = {
                name: f.state?.name ?? "state_id",
                label: f.state?.label ?? "estado",
                modelValue: null,
                othersProps: f.state?.othersProps ?? null,
            };
            if (props.object) {
                country.modelValue = props.object[country.name];
                state.modelValue = props.object[state.name];
            }
            formData.value[country.name] = country.modelValue;
            formData.value[state.name] = state.modelValue;
            f.country = country;
            f.state = state;
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
        } else if (f.type === "subtitles") {
            formData.value[f.name] = props.object ? props.object[f.name] : [];
        } else if (f.type === "daterange") {
            formData.value[f.startName] = props.object
                ? props.object[f.startName]
                : null;
            formData.value[f.endName] = props.object
                ? props.object[f.endName]
                : null;
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
            if (props.object) {
                update();
            } else {
                store(hide);
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
            "put",
            true
        );
    } else {
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
    }
};

const saveAxiosRequest = async (url, method, hide) => {
    Loading.show();
    await axios[method](url, formData.value)
        .then((res) => {
            const data = res.data;
            if (data.success) {
                success(data.message);
                setDefaultData();
                emits(
                    method === "post" ? "created" : "updated",
                    data.object,
                    hide
                );
            }
        })
        .finally(() => {
            Loading.hide();
        });
};
</script>
