<template>
    <btn-add-component @click="showDialog = true" />
    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        position="right"
        @before-show="onShow"
        @hide="emits('hide')"
    >
        <q-card>
            <dialog-header-component
                :icon="icon"
                :title="`${object ? 'editar' : 'adicionar'} seccion`"
                closable
                @close="showDialog = false"
            />
            <q-card-section
                :style="{
                    height: `${Screen.height - 150}px`,
                }"
                class="col q-pt-none scroll"
            >
                <q-form class="q-mt-sm" ref="form" greedy>
                    <editor-field
                        name="text"
                        label="descripcion"
                        :model-value="formData.text"
                        :othersProps="{ required: true }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <checkbox-field
                        name="has_file"
                        label="agregar video/imagen"
                        class="q-mt-md"
                        :model-value="formData.has_file"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <file-field
                        name="file"
                        icon="mdi-file"
                        label="video/imagen"
                        :othersProps="{ required: true, icon: 'mdi-file' }"
                        @update="(name, val) => (formData[name] = val)"
                        v-if="formData.has_file"
                    />
                    <br v-if="!formData.has_file" />
                    <checkbox-field
                        name="has_btn"
                        label="agregar boton"
                        class="q-mt-md"
                        :model-value="formData.has_btn"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <text-field
                        label="texto del boton"
                        name="button"
                        :model-value="formData.button"
                        :othersProps="{ required: true }"
                        @update="(name, val) => (formData[name] = val)"
                        v-if="formData.has_btn"
                    />
                    <br v-if="!formData.has_btn" />
                    <checkbox-field
                        name="bg_primary"
                        label="establecer fondo color azul corporativo"
                        class="q-mt-md"
                        :model-value="formData.bg_primary"
                        @update="(name, val) => (formData[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-card-actions>
                <btn-save-component @click="save" />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "SectionComponent",
});

import { ref, onMounted, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import EditorField from "../../form/input/EditorField.vue";
import FileField from "../../form/input/FileField.vue";
import TextField from "../../form/input/TextField.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Dark, Screen } from "quasar";
import { error, errorValidation } from "../../../helpers/notifications";

const props = defineProps({
    object: {
        type: Object,
        default: null,
    },
    show: Boolean,
});

const emits = defineEmits(["created", "updated", "hide"]);

const fullTitle = ref(null);
const icon = ref(null);
const showDialog = ref(false);
const form = ref(null);

const page = usePage();
const properties = {
    has_file: false,
    has_btn: false,
    bg_primary: false,
    text: null,
    file: null,
    button: null,
};
const formData = useForm({
    has_file: false,
    has_btn: false,
    bg_primary: false,
    text: null,
    file: null,
    button: null,
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

watch(
    () => props.show,
    (n) => {
        if (n) {
            showDialog.value = true;
        }
    }
);

const onShow = () => {
    Object.assign(formData, props.object?.data ?? properties);
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            emits(
                props.object ? "updated" : "created",
                { ...formData },
                props.object?.index ?? null
            );
            showDialog.value = false;
        } else {
            errorValidation();
        }
    });
};
</script>
