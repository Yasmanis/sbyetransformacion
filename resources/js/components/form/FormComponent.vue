<template>
    <btn-copy-component @click="showDialog = true" v-if="duplicate" />
    <btn-add-component @click="showDialog = true" v-else-if="!object?.id" />
    <btn-edit-component @click="showDialog = true" v-else />
    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        :position="position"
        :full-hight="fullHeight"
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="icon"
                :title="fullTitle"
                closable
                @close="onBeforeClose"
            />
            <form-body
                :object="currentObject"
                :fields="fields"
                :module="module"
                :post-on-update="postOnUpdate"
                :new-on-create="newOnCreate"
                :axios-request="axiosRequest"
                @created="onCreated"
                @updated="onUpdated"
                @cancel="showDialog = false"
            />
        </q-card>
    </q-dialog>

    <confirm-component
        :show="showConfirm"
        :cancel="true"
        iconHeader="mdi-check-circle-outline"
        message="existen datos sin guardar, desea continuar?"
        @hide="showConfirm = false"
        @ok="
            {
                showConfirm = false;
                showDialog = false;
            }
        "
    />
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted, watch } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../btn/BtnAddComponent.vue";
import BtnEditComponent from "../btn/BtnEditComponent.vue";
import BtnCopyComponent from "../btn/BtnCopyComponent.vue";
import FormBody from "./FormBody.vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";
import { formData, originalData } from "../../helpers/formData";
import { isEqual } from "lodash";

const props = defineProps({
    module: {
        type: Object,
        default: () => {},
    },
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
    fields: {
        type: Array,
        default: () => [],
    },
    position: {
        type: String,
        default: "right",
    },
    fullHeight: {
        type: Boolean,
        default: true,
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
    duplicate: Boolean,
    closeConfirm: Boolean,
});

const emits = defineEmits(["created", "updated"]);

const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const setDefault = ref(false);
const page = usePage();
const currentObject = ref(null);
const showConfirm = ref(false);

onMounted(() => {
    const module = props.module;
    if (props.object?.id) {
        fullTitle.value = `editar ${
            props.object[module.to_str] ?? module.singular_label.toLowerCase()
        }`;
        icon.value = `img:${page.props.public_path}images/icon/${
            Dark.isActive ? "white" : "black"
        }-edit.png`;
        currentObject.value = { ...props.object };
        if (props.duplicate) {
            delete currentObject.value.id;
            fullTitle.value = `duplicar ${
                props.object[module.to_str] ??
                module.singular_label.toLowerCase()
            }`;
            icon.value = "mdi-content-copy";
        }
    } else {
        fullTitle.value = `adicionar ${module.singular_label.toLowerCase()}`;
        icon.value = "mdi-plus";
    }
});

watch(
    () => props.object,
    (n) => {
        if (n?.id) {
            currentObject.value = { ...n };
            if (props.duplicate) {
                delete currentObject.value.id;
            }
        }
    },
    { deep: true }
);

const onBeforeClose = () => {
    if (!props.closeConfirm || isEqual(formData.value, originalData.value)) {
        showDialog.value = false;
    } else {
        showConfirm.value = true;
    }
};

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};

const onCreated = (object, close) => {
    emits("created", object);
    if (close) {
        showDialog.value = false;
    }
};

const onUpdated = (object) => {
    emits("updated", object);
    showDialog.value = false;
};
</script>
