<template>
    <q-list dense class="q-pa-none q-ma-none full-width">
        <q-item style="padding: 0px" v-if="default_selected.length > 0">
            <q-item-section>
                <q-item-label>{{ label }} </q-item-label>
            </q-item-section>
        </q-item>
        <q-item style="padding: 0px">
            <q-item-section v-if="default_selected.length === 0">
                <q-input
                    dense
                    readonly
                    hide-bottom-space
                    :label="label"
                    :hint="!errorMsg ? (required ? 'requerido' : '') : ''"
                    :rules="rules"
                />
                <q-item-label
                    class="q-field--error"
                    v-if="errorMsg"
                    style="margin-left: -12px; margin-top: -20px"
                >
                    <div
                        class="q-field__bottom row items-start q-field__bottom--stale"
                    >
                        <div class="q-field__messages col">
                            <div role="alert">{{ errorMsg }}</div>
                        </div>
                    </div>
                </q-item-label>
            </q-item-section>

            <users-selected-component
                :imgbase="imgbase"
                :list="default_selected"
                @clear="onClear"
                @remove-item="onRemove"
                v-else
            />

            <q-item-section avatar style="min-width: 30px; height: 40px">
                <q-btn-component
                    :tooltips="`seleccionar ${
                        multiple ? 'usuarios' : 'usuario'
                    }`"
                    icon="mdi-account-circle"
                    v-if="multiple"
                >
                    <q-menu ref="menuRef">
                        <q-list dense>
                            <q-item
                                clickable
                                v-close-popup
                                @click="showDialog = true"
                                style="padding-left: 0"
                            >
                                <q-item-section
                                    avatar
                                    style="padding-right: 0; min-width: 40px"
                                >
                                    <q-avatar
                                        icon="mdi-account-check-outline"
                                    />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label
                                        >seleccionar usuarios</q-item-label
                                    >
                                </q-item-section>
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="allUsers"
                                style="padding-left: 0"
                            >
                                <q-item-section
                                    avatar
                                    style="padding-right: 0; min-width: 40px"
                                >
                                    <q-avatar
                                        icon="mdi-account-multiple-check-outline"
                                    />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label
                                        >todos los usuarios</q-item-label
                                    >
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn-component>
                <q-btn-component
                    tooltips="seleccionar usuario"
                    icon="mdi-account-circle"
                    @click="showDialog = true"
                    v-else
                />
            </q-item-section>
        </q-item>
    </q-list>

    <q-dialog v-model="showDialog" persistent position="right">
        <q-card>
            <dialog-header-component
                icon="mdi-account-circle"
                :title="
                    multiple ? 'seleccionar usuarios' : 'seleccionar usuario'
                "
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <users-select-component
                    :imgbase="imgbase"
                    :url="url"
                    @change="onChange"
                    :modelValue="current_selected"
                    :multiple="multiple"
                />
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component @click="onSave" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import UsersSelectComponent from "./UsersSelectComponent.vue";
import UsersSelectedComponent from "./UsersSelectedComponent.vue";
import { Loading } from "quasar";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import { error, error500 } from "../../../helpers/notifications";

defineOptions({
    name: "UsersSelectDialogComponent",
});

const props = defineProps({
    label: String,
    name: {
        type: String,
        required: true,
    },
    errors: {
        type: Object,
        default: null,
    },
    required: {
        type: Boolean,
        default: true,
    },
    multiple: {
        type: Boolean,
        default: true,
    },
    url: String,
    imgbase: String,
    modelValue: {
        type: Array,
        default: [],
    },
});

const emits = defineEmits(["update"]);
const page = usePage();
const showDialog = ref(false);
const menuRef = ref(null);
const default_selected = ref([]);
const current_selected = ref([]);
const rules = ref(null);

onMounted(() => {
    default_selected.value = props.modelValue;
    if (props.required) {
        rules.value = [(val) => !!val || "requerido"];
    }
});

watch(default_selected, (n) => {
    setDefaults(current_selected, n);
    emits("update", props.name, n);
});

const onChange = (users) => {
    current_selected.value = users;
};

const onRemove = (usr) => {
    default_selected.value = default_selected.value.filter(
        (u) => u.value !== usr.value
    );
};

const onClear = () => {
    default_selected.value = [];
};

const allUsers = async () => {
    Loading.show();
    await axios
        .get("/users")
        .then((response) => {
            default_selected.value = response.data.options;
        })
        .catch((error) => {
            error500();
        })
        .finally(() => {
            Loading.hide();
        });
};

const setDefaults = (arr, items) => {
    let selected = [];
    for (let i = 0; i < items.length; i++) {
        selected.push(items[i]);
    }
    arr.value = selected;
};

const onSave = () => {
    let selected = [];
    for (let i = 0; i < current_selected.value.length; i++) {
        selected.push(current_selected.value[i]);
    }
    default_selected.value = selected;
    showDialog.value = false;
};

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
