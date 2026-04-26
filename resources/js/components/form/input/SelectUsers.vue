<template>
    <q-btn-component
        :tooltips="`seleccionar ${multiple ? 'usuarios' : 'usuario'}`"
        :icon="icon"
        :size="iconSize"
        :disable="disable"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        position="right"
        @before-show="loadUsers"
    >
        <q-card>
            <dialog-header-component
                :icon="icon"
                :icon-size="iconSize"
                :title="`seleccionar ${multiple ? 'usuarios' : 'usuario'}`"
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
import { ref, onMounted, watch, computed, onBeforeMount } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import UsersSelectComponent from "../../modules/user/UsersSelectComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { validations } from "../../../helpers/validations";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";
import { Loading } from "quasar";

defineOptions({
    name: "SelectUsers",
});

const props = defineProps({
    attachTo: Object,
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
    disable: {
        type: Boolean,
        default: false,
    },
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
});

const onChange = (opts) => {
    currentSelected.value = opts ? (Array.isArray(opts) ? opts : [opts]) : [];
};

const loadUsers = async () => {
    let data = {
        roleStr: props.selectedRole,
    };
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
        })
        .catch((error) => {
            error500();
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
        props.attachTo,
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
