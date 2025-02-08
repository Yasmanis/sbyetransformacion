<template>
    <btn-add-component @click="showDialog = true" v-if="!object" />
    <btn-edit-component @click="showDialog = true" v-else />

    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
        allow-focus-outside
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

import { ref, onMounted, computed } from "vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
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
const showDialog = ref(false);
const setDefault = ref(false);

const page = usePage();

const icon = computed(() => {
    return props.object
        ? `img:${page.props.public_path}images/icon/${
              Dark.isActive ? "white" : "black"
          }-edit.png`
        : "add";
});

onMounted(() => {
    if (props.object != null) {
        fullTitle.value = `Editar ${props.title}`;
    } else {
        fullTitle.value = `Adicionar ${props.title}`;
    }
});

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};

const onCreated = (object, close) => {
    if (close) {
        showDialog.value = true;
    }
};

const onUpdated = (object, close) => {
    if (close) {
        showDialog.value = true;
    }
};
</script>
