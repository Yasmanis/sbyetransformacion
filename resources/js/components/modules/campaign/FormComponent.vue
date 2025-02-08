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
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <text-field
                                label="titulo"
                                name="title"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                            <text-field
                                label="url"
                                name="url"
                                :othersProps="{
                                    required: true,
                                    type: 'url',
                                }"
                            />
                        </div>
                        <div
                            class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"
                            :class="
                                !screen.xs ? 'q-pl-md' : 'q-mb-xs order-first'
                            "
                        >
                            <image-field
                                height="100px"
                                width="100px"
                                name="logo"
                                label="logo"
                            />
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <form-body
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
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "../../form/input/TextField.vue";
import ImageField from "../../form/input/ImageField.vue";
import FormBody from "../../form/FormBody.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark, useQuasar } from "quasar";

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
const emits = defineEmits(["created", "updated"]);
const $q = useQuasar();
const form = ref(null);
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
        field: "sections",
        name: "sections",
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

const screen = computed(() => {
    return $q.screen;
});

const onHide = () => {
    setDefault.value = !setDefault.value;
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
