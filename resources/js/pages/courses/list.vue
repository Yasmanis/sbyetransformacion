<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="[]"
                :updateFields="[]"
            >
                <template #body-cell-ico="props">
                    <q-icon :name="getIcon(props.props.row)" size="sm" />
                </template>

                <!-- <template #add v-if="has_add">
                    <btn-add-component
                        @click="
                            () => {
                                current_object = null;
                                showDialog = true;
                            }
                        "
                    />
                </template>

                <template #edit="props" v-if="has_edit">
                    <btn-edit-component
                        @click="
                            () => {
                                current_object = props.props.row;
                                showDialog = true;
                            }
                        "
                    />
                </template> -->

                <template #delete="props" v-if="has_delete"
                    ><span></span>
                </template>

                <template #item-section-ico="props">
                    <q-icon :name="getIcon(props.props.row)" size="sm" />
                </template>
            </table-component>
        </q-page>
    </Layout>

    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        position="right"
        @beforeShow="setDefaultData()"
        @hide="$page.props.errors = {}"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="
                    current_object
                        ? `img:${$page.props.public_path}images/icon/${
                              Dark.isActive ? 'white' : 'black'
                          }-edit.png`
                        : 'mdi-plus'
                "
                :title="
                    current_object
                        ? `editar ${
                              current_object[current_module.to_str] ??
                              current_module.singular_label.toLowerCase()
                          }`
                        : `adicionar ${current_module.singular_label.toLowerCase()}`
                "
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <text-field
                        name="plural_label"
                        label="nombre"
                        :model-value="formData.plural_label"
                        :othersProps="{
                            required: true,
                        }"
                        @update="onChangeField"
                    />
                    <text-field
                        name="ico"
                        label="imagen estilo css"
                        :model-value="formData.ico"
                        :othersProps="{
                            required: true,
                        }"
                        :clearable="false"
                        @update="onChangeField"
                        v-if="!formData.ico_from_path"
                    >
                        <template #after v-if="formData.ico">
                            <q-icon :name="formData.ico" />
                        </template>
                    </text-field>
                    <template v-else>
                        <file-field
                            label="imagen blanca"
                            name="white_image"
                            :model-value="formData.white_image"
                            :othersProps="{
                                required: true,
                                icon: 'mdi-file-image-outline',
                                accept: 'image/*',
                            }"
                            @update="onChangeField"
                        />
                        <file-field
                            label="imagen negra"
                            name="black_image"
                            :model-value="formData.black_image"
                            :othersProps="{
                                required: true,
                                icon: 'mdi-file-image-outline',
                                accept: 'image/*',
                            }"
                            @update="onChangeField"
                        />
                    </template>
                    <checkbox-field
                        name="ico_from_path"
                        label="establecer imagen desde archivo"
                        :model-value="formData.ico_from_path"
                        @update="onChangeField"
                    />
                    <text-field
                        name="model"
                        label="acceder a traves de"
                        :model-value="formData.model"
                        :othersProps="{
                            required: true,
                        }"
                        @update="onChangeField"
                    />
                    <q-item-label
                        >se usara la siguiente url para acceder al
                        modulo</q-item-label
                    >
                    <q-item-label caption>{{ getUrl }}</q-item-label>
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save(true)" />
                <btn-save-and-new-component
                    @click="save(false)"
                    v-if="!current_object"
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
import { computed, onBeforeMount, ref, watch } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";
import DialogHeaderComponent from "../../components/base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../components/btn/BtnAddComponent.vue";
import BtnEditComponent from "../../components/btn/BtnEditComponent.vue";
import { Dark, uid } from "quasar";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { getActiveModule } from "../../services/current_module";
import TextField from "../../components/form/input/TextField.vue";
import CheckboxField from "../../components/form/input/CheckboxField.vue";
import FileField from "../../components/form/input/FileField.vue";
import BtnSaveComponent from "../../components/btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../../components/btn/BtnSaveAndNewComponent.vue";
import BtnCancelComponent from "../../components/btn/BtnCancelComponent.vue";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "ListPage",
});

const showDialog = ref(false);
const current_module = ref(null);
const current_object = ref(null);
const has_add = ref(false);
const has_edit = ref(false);
const has_delete = ref(false);
const form = ref(null);

const formData = ref({ ico_from_path: false });

const name = {
    field: "plural_label",
    name: "plural_label",
    label: "nombre",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
    },
};

const ico = {
    field: "ico",
    name: "ico",
    align: "left",
    type: "text",
    required: true,
    style: "width: 10px",
    othersProps: {
        required: true,
    },
};

const searchFields = [name];

const columns = [
    ico,
    name,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "190px",
    },
];

const filterFields = [];

onBeforeMount(() => {
    current_module.value = getActiveModule();
    const permissions = current_module.value.permissions.map((p) => p.name);
    const modelName = current_module.value.model.toLowerCase();
    has_add.value = permissions.includes(`add_${modelName}`);
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);
});

watch(
    () => formData.value.ico_from_path,
    () => {
        formData.value.ico = "help";
    }
);

const setDefaultData = () => {
    let data = {
        singular_label: current_object.value?.singular_label ?? null,
        plural_label: current_object.value?.plural_label ?? null,
        ico: current_object.value?.ico ?? "help",
        ico_from_path: current_object.value?.ico_from_path ?? false,
        black_image: current_object.value?.ico ?? null,
        white_image: current_object.value?.ico ?? null,
        model: current_object.value?.model ?? new Date().getTime(),
    };
    Object.keys(data).forEach((k) => {
        formData.value[k] = data[k];
    });
};

const getUrl = computed(() => {
    return `${window.location.origin}/admin/cursos/${
        formData.value.model ?? "..."
    }`;
});

const getIcon = (row) => {
    let { ico, ico_from_path } = row;
    if (ico_from_path) {
        let img = `img:${usePage().props.public_path}`;
        if (Dark.isActive) {
            ico = ico.replace("black", "white");
        } else {
            ico = ico.replace("white", "black");
        }
        return `${img}${ico}`;
    }
    return ico;
};

const onChangeField = (name, val) => {
    if (name === "plural_label") {
        formData.value["singular_label"] = val;
    }
    formData.value[name] = val;
};

const save = async (close) => {
    form.value.validate().then((success) => {
        if (success) {
            if (current_object.value?.id) {
                update();
            } else {
                store(close);
            }
        } else {
            errorValidation();
        }
    });
};

const store = async (close) => {
    useForm(formData.value).post(current_module.value.base_url, {
        onSuccess: () => {
            if (close) {
                showDialog.value = false;
            } else {
                setDefaultData();
            }
            current_object.value = null;
        },
    });
};

const update = async () => {
    useForm({ ...formData.value, _method: "put" }).post(
        `${current_module.value.base_url}/${current_object.value.id}`,
        {
            onSuccess: () => {
                showDialog.value = false;
                current_object.value = null;
            },
        }
    );
};
</script>
