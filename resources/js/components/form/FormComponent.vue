<template>
    <q-btn-component
        :tooltips="object === null ? 'adicionar' : 'editar'"
        :icon="icon"
        :size="size"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="icon"
                :title="
                    object
                        ? `editar ${object[module.to_str]}`
                        : `adicionar ${module.singular_label.toLowerCase()}`
                "
                closable
            />
            <form-body
                :object="object"
                :fields="fields"
                :module="module"
                @close="showDialog = false"
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
import QBtnComponent from "../base/QBtnComponent.vue";
import FormBody from "./FormBody.vue";
import { usePage } from "@inertiajs/vue3";

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
});

const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const setDefault = ref(false);

const page = usePage();

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
        icon.value = `img:${page.props.public_path}images/icon/white-edit.png`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
        icon.value = "add";
    }
});

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};
</script>
