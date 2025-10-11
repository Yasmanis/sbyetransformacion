<template>
    <btn-add-component @click="showDialog = true" v-if="!object?.id" />
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
                :title="
                    object?.id
                        ? `editar ${
                              object[module.to_str] ??
                              module.singular_label.toLowerCase()
                          }`
                        : `adicionar ${module.singular_label.toLowerCase()}`
                "
                closable
            />
            <form-body
                :object="object"
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
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../btn/BtnAddComponent.vue";
import BtnEditComponent from "../btn/BtnEditComponent.vue";
import FormBody from "./FormBody.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

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
});

const emits = defineEmits(["created", "updated"]);

const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const setDefault = ref(false);

const page = usePage();

onMounted(() => {
    if (props.object?.id) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = `img:${page.props.public_path}images/icon/${
            Dark.isActive ? "white" : "black"
        }-edit.png`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "mdi-plus";
    }
});

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
