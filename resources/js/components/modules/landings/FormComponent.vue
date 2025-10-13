<template>
    <btn-add-component @click="showDialog = true" v-if="!object" />
    <btn-edit-component @click="showDialog = true" v-else />
    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        full-height
        full-width
        position="standard"
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="icon"
                :title="
                    object
                        ? `editar ${
                              object[module.to_str] ??
                              module.singular_label.toLowerCase()
                          }`
                        : `adicionar ${module.singular_label.toLowerCase()}`
                "
                closable
                @close="showDialog = false"
            />
            <q-card-section
                :style="{
                    height: `${Screen.height - 150}px`,
                }"
                class="scroll"
            >
                <Layout :header="false">
                    <div class="banner bg-primary q-pt-lg">
                        <div class="row" v-if="formData.logo">
                            <div
                                class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12"
                            >
                                <img
                                    :src="`${$page.props.public_path}images/logo/1.png`"
                                    width="180px"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-md-5 col-sm-12 col-xs-12 text-center"
                                style="z-index: 1"
                            >
                                <q-img
                                    :src="formData.image"
                                    style="width: 50%; z-index: 9999 !important"
                                    class="cursor-pointer"
                                    @click="fileRef.pickFiles()"
                                    ><q-tooltip-component
                                        title="click para editar"
                                /></q-img>
                            </div>
                            <div
                                class="col-md-7 col-sm-12 col-xs-12 text-center text-white"
                            >
                                <div>
                                    <span
                                        v-html="formData.text"
                                        class="cursor-pointer"
                                    >
                                    </span>
                                    <q-popup-edit
                                        buttons
                                        v-model="formData.text"
                                        v-slot="scope"
                                        class="popup-editor"
                                    >
                                        <editor-field
                                            name="text"
                                            :model-value="scope.value"
                                            height="400px"
                                            @update="
                                                (name, val) =>
                                                    (formData[name] = val)
                                            "
                                        />
                                    </q-popup-edit>
                                    <q-tooltip-component
                                        title="click para editar"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            class="wave overflow-hidden"
                            :style="{
                                'margin-top':
                                    !Screen.xs && !Screen.sm ? '-130px' : '',
                            }"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 1000 100"
                                preserveAspectRatio="none"
                                class="d-block position-relative"
                            >
                                <path
                                    class="elementor-shape-fill"
                                    d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3 c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3 c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <div
                        v-for="(s, index) in formData.sections"
                        :key="`section-${index}`"
                        class="row items-center container q-py-xl cursor-pointer"
                        :class="{
                            'bg-primary': s.bg_primary,
                            'text-white': s.bg_primary,
                        }"
                        style="margin-top: -5px"
                        @click="onClickSection(index)"
                    >
                        <div
                            :class="
                                s.has_file
                                    ? 'col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6'
                                    : 'col'
                            "
                        >
                            <span v-html="s.text"></span>
                            <div class="text-center" v-if="s.button">
                                <q-btn
                                    color="black"
                                    :label="s.button"
                                    no-caps
                                    rounded
                                    @click.stop="(ev) => ev.preventDefault()"
                                >
                                    <q-icon
                                        name="fa fa-long-arrow-right"
                                        size="xs"
                                        class="q-ml-md"
                                    />
                                </q-btn>
                            </div>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center"
                            v-if="s.file"
                        >
                            <q-img
                                :src="getUrlFromFile(s.file)"
                                alt="group-image"
                                style="width: 50%"
                                v-if="s.file.type.startsWith('image')"
                            />
                        </div>
                        <q-tooltip-component title="click para editar" />
                    </div>
                </Layout>
            </q-card-section>
            <q-card-actions>
                <section-component
                    :object="currentSection"
                    :show="showSectionDialog"
                    @created="onCreatedSection"
                    @updated="onUpdateSection"
                    @hide="
                        () => {
                            showSectionDialog = false;
                            currentSection = null;
                        }
                    "
                />
                <btn-save-component />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <q-file
        v-model="file"
        ref="fileRef"
        @update:model-value="onChangeFile"
        accept="image/*"
        @rejected="onRejected"
        style="display: none"
    ></q-file>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import EditorField from "../../form/input/EditorField.vue";
import Layout from "../../../layouts/MainLayout.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import SectionComponent from "./SectionComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Dark, Screen } from "quasar";
import { error } from "../../../helpers/notifications";

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
const currentSection = ref(null);
const showSectionDialog = ref(false);

const file = ref(null);
const fileRef = ref(null);

const page = usePage();
const formData = useForm({
    logo: true,
    image: `${page.props.public_path}images/others/free_learning_header.webp`,
    text: "asd",
    sections: [],
});

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

const onClickSection = (index) => {
    currentSection.value = {
        index,
        data: formData.sections[index],
    };
    showSectionDialog.value = true;
};

const onCreatedSection = (data) => {
    formData.sections.push(data);
};

const onUpdateSection = (data, index) => {
    formData.sections[index] = data;
};

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};

const onChangeFile = (f) => {
    formData.image = URL.createObjectURL(f);
};

const getUrlFromFile = (f) => {
    console.log(f);

    return URL.createObjectURL(f);
};

const onRejected = (e) => {
    error("el fichero seleccionado no es una imagen");
};
</script>

<style>
.popup-editor {
    min-height: 100px !important;
    max-width: 400px !important;
}
</style>
