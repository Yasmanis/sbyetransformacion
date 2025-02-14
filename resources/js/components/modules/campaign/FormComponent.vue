<template>
    <q-btn-component
        :tooltips="
            defaultTooltips ? defaultTooltips : object ? 'editar' : 'adicionar'
        "
        :icon="defaultIcon ? defaultIcon : icon"
        @click="showDialog = true"
    />
    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
        @before-show="setDefaultData"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="icon"
                :title="
                    object ? `editar ${object['title']}` : `adicionar campaña`
                "
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <text-field
                                label="titulo"
                                name="title"
                                :modelValue="formData.title"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                            <text-field
                                label="url"
                                name="url"
                                :modelValue="formData.url"
                                :othersProps="{
                                    required: true,
                                    type: 'url',
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"
                            :class="
                                !screen.xs ? 'q-pl-md' : 'q-mb-xs order-first'
                            "
                        >
                            <image-field
                                :modelValue="formData.logo"
                                height="100px"
                                width="100px"
                                name="logo"
                                label="logo"
                                @change="onUpdateField"
                            />
                        </div>
                    </div>
                    <div class="row q-mt-none">
                        <select-field
                            name="sections_id"
                            label="secciones"
                            :modelValue="formData.sections_id"
                            :multiple="true"
                            :othersProps="{
                                url_to_options:
                                    '/category-nomenclatures/section',
                                required: true,
                            }"
                            @update="onUpdateField"
                        />
                        <users-select-dialog-component
                            label="usuarios"
                            name="assigned_to_id"
                            :default_users="users"
                            @update="onUpdateUsers"
                        />
                    </div>
                    <periodicity-field
                        :data="periodicity"
                        @update="onUpdateField"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save(true)" />
                <btn-save-and-new-component
                    @click="save(false)"
                    v-if="!object"
                />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted, computed } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "../../form/input/TextField.vue";
import ImageField from "../../form/input/ImageField.vue";
import SelectField from "../../form/input/SelectField.vue";
import PeriodicityField from "../../form/input/PeriodicityField.vue";
import UsersSelectDialogComponent from "../user/UsersSelectDialogComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../../btn/BtnSaveAndNewComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Dark, useQuasar } from "quasar";

const props = defineProps({
    module: Object,
    fields: {
        type: Array,
        default: () => [],
    },
    size: {
        type: String,
        default: "xs",
    },
    object: {
        type: Object,
        default: null,
    },
    fieldToStr: {
        type: String,
        default: "id",
    },
    title: {
        type: String,
        default: "Object",
    },
    position: {
        type: String,
        default: "right",
    },
    fullHeight: {
        type: Boolean,
        default: true,
    },
    defaultIcon: String,
    defaultTooltips: String,
});
const emits = defineEmits(["created", "updated"]);
const $q = useQuasar();
const form = ref(null);
const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const formData = useForm({
    title: null,
    url: null,
    sections_id: null,
    start_date: null,
    end_date: null,
    logo: null,
    assigned_to_id: null,
    _method: null,
});
const periodicity = ref(null);
const users = ref([]);
const page = usePage();

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = `img:${page.props.public_path}images/icon/${
            Dark.isActive ? "white" : "black"
        }-edit.png`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "mdi-plus";
    }
});

const screen = computed(() => {
    return $q.screen;
});

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const onUpdateUsers = (name, val) => {
    formData[name] = val ? val.map((v) => v.value) : val;
};

const setDefaultData = () => {
    formData["title"] = props.object ? props.object.title : null;
    formData["url"] = props.object ? props.object.url : null;
    formData["sections_id"] = props.object ? props.object.sections_id : null;
    formData["start_date"] = props.object ? props.object.start_date : null;
    formData["end_date"] = props.object ? props.object.end_date : null;
    formData["logo"] = props.object
        ? props.object.logo
            ? `${page.props.public_path}storage/${props.object.logo}`
            : null
        : null;
    formData["_method"] = props.object ? "put" : "post";
    users.value = props.object
        ? props.object.assigned_to_id.map((u) => {
              return {
                  value: u.id,
                  label: u.full_name,
              };
          })
        : [];
    if (props.object)
        periodicity.value = {
            start: props.object.start_date,
            end: props.object.end_date,
        };
    else periodicity.value = null;
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
    formData.post("/admin/campaigns", {
        onSuccess: (data) => {
            emits("created", data.props.object);
            if (hide) {
                showDialog.value = false;
            } else {
                setDefaultData();
            }
        },
    });
};

const update = async () => {
    formData.post(`/admin/campaigns/${props.object.id}`, {
        onSuccess: (data) => {
            emits("updated", data.props.object);
            showDialog.value = false;
        },
    });
};

const onHide = () => {
    page.props.errors = {};
};

const onCreated = (object, close) => {
    if (close) {
        showDialog.value = false;
    }
    emits("created", object);
};

const onUpdated = (object, close) => {
    if (close) {
        showDialog.value = false;
    }
    emits("updated", object);
};
</script>
