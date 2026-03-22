<template>
    <q-list dense class="q-pa-none q-ma-none full-width">
        <q-item
            style="padding: 0px"
            v-if="defaultSelected.length > 0 && showLabelWhenSelected"
        >
            <q-item-section>
                <q-item-label>{{ label }} </q-item-label>
            </q-item-section>
        </q-item>
        <q-item style="padding: 0px">
            <q-item-section
                class="cursor-pointer"
                v-if="defaultSelected.length === 0"
                @click="showDialog = true"
            >
                <q-input
                    dense
                    readonly
                    hide-bottom-space
                    :label="label"
                    :rules="rules"
                >
                    <template #label v-if="label"
                        >{{ label }}
                        <span class="text-red" v-if="required">
                            *</span
                        ></template
                    >
                </q-input>
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
                :list="defaultSelected"
                @clear="onClearSelected"
                @remove-item="onRemoveItem"
                v-else
            />

            <q-item-section avatar style="min-width: 30px; height: 40px">
                <q-btn-component
                    :tooltips="`seleccionar ${
                        multiple ? 'usuarios' : 'usuario'
                    }`"
                    :icon="icon"
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
                                @click="onSelectAllUsers"
                                style="padding-left: 0"
                                v-if="allUsers.length > 0"
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
                    :tooltips="`seleccionar ${label ?? 'usuario'}`"
                    :icon="icon"
                    :size="iconSize"
                    @click="showDialog = true"
                    v-else
                />
            </q-item-section>
        </q-item>
    </q-list>

    <q-dialog v-model="showDialog" persistent position="right">
        <q-card>
            <dialog-header-component
                :icon="icon"
                :icon-size="iconSize"
                title="seleccionar..."
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <users-select-component
                    :url="url"
                    :modelValue="modelValue"
                    :multiple="multiple"
                    :selected-role="selectedRole"
                    @change="onChange"
                />
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component @click="onConfirm" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch, computed, onBeforeMount } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import UsersSelectComponent from "./UsersSelectComponent.vue";
import UsersSelectedComponent from "./UsersSelectedComponent.vue";
import { Loading } from "quasar";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import { error500 } from "../../../helpers/notifications";

defineOptions({
    name: "UsersSelectDialogComponent",
});

const props = defineProps({
    label: String,
    name: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        default: "mdi-account-circle",
    },
    iconSize: {
        type: String,
        default: "md",
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
    showLabelWhenSelected: {
        type: Boolean,
        default: true,
    },
    url: String,
    modelValue: Array | Number,
    selectedRole: String | Number,
});

const emits = defineEmits(["update"]);
const page = usePage();
const showDialog = ref(false);
const rules = ref(null);
const allUsers = ref([]);
const defaultSelected = ref([]);
const currentSelected = ref([]);

onBeforeMount(() => {
    if (props.required) {
        rules.value = [(val) => !!val || "requerido"];
    }
    loadUsers();
});

const onChange = (opts) => {
    currentSelected.value = opts ? (Array.isArray(opts) ? opts : [opts]) : [];
};

const loadUsers = async () => {
    let data = {
        roleStr: props.selectedRole,
    };
    Loading.show();
    await axios
        .post("/users", data)
        .then((response) => {
            allUsers.value = response.data.options;
            if (props.modelValue) {
                if (Array.isArray(props.modelValue)) {
                    defaultSelected.value = allUsers.value.filter((u) =>
                        props.modelValue.includes(u.value),
                    );
                } else {
                    let found = allUsers.value.find(
                        (u) => props.modelValue === u.value,
                    );
                    defaultSelected.value = found ? [found] : [];
                }
            }
            onUpdate();
        })
        .catch((error) => {
            error500();
        })
        .finally(() => {
            Loading.hide();
        });
};

const onSelectAllUsers = () => {
    defaultSelected.value = [...allUsers.value];
    onUpdate();
};

const onRemoveItem = (item) => {
    defaultSelected.value = defaultSelected.value.filter(
        (s) => s.value !== item.value,
    );
    onUpdate();
};

const onClearSelected = () => {
    defaultSelected.value = [];
    onUpdate();
};

const onConfirm = () => {
    defaultSelected.value = [...currentSelected.value];
    onUpdate();
    showDialog.value = false;
};

const onUpdate = () => {
    let n = defaultSelected.value;
    emits(
        "update",
        props.name,
        n.length > 0
            ? props.multiple
                ? n.map((s) => s.value)
                : n[0].value
            : props.multiple
              ? []
              : null,
    );
};

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
