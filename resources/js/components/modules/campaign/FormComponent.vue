<template>
    <q-btn-component
        tooltips="crear campaña"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-campaign.png`"
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
                    object ? `editar ${object['title']}` : `adicionar campaña`
                "
                closable
            />
            <form-body
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
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import FormBody from "../../form/FormBody.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

const props = defineProps({
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
const icon = ref(null);
const showDialog = ref(false);
const setDefault = ref(false);
const module = ref({
    singular_label: "Campaña",
    plural_label: "Campañas",
    model: "Campaign",
    ico: "mdi-view-list",
    base_url: "/admin/campaigns",
    to_str: "title",
});

const page = usePage();

const fields = ref([
    {
        name: "title",
        label: "titulo",
        type: "text",
        othersProps: {
            required: true,
        },
    },
    {
        name: "url",
        label: "url",
        type: "text",
        othersProps: {
            required: true,
            type: "url",
        },
    },
    {
        field: "section_id",
        name: "section_id",
        label: "secciones",
        type: "select",
        othersProps: {
            url_to_options: "/category-nomenclatures/section",
            multiple: true,
            required: true,
        },
    },
    {
        field: "users",
        name: "users",
        label: "usuarios",
        type: "users",
    },
    {
        field: "users",
        name: "users",
        label: "usuarios",
        type: "periodicity",
    },
]);

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

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};
</script>
