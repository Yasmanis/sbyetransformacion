<template>
    <q-btn-component
        tooltips="adicionar seccion"
        icon="mdi-plus"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        @before-show="onBeforeShowDialog"
        @hide="onHide"
    >
        <q-card style="width: 800px">
            <dialog-header-component
                icon="mdi-plus"
                title="añadir seccion y temas"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <text-field
                        v-model="formData['name']"
                        label="nombre"
                        name="name"
                        :othersProps="{
                            required: true,
                        }"
                        :modelValue="formData['name']"
                        @update="onUpdateField"
                    />
                    <checkbox-field
                        label="añadir descripcion"
                        name="add_description"
                        :modelValue="formData['add_description']"
                        class="q-ml-none"
                        @update="onUpdateField"
                    />
                    <editor-field
                        v-model="formData['description_section']"
                        name="description_section"
                        :rows="3"
                        :modelValue="formData['description_section']"
                        :othersProps="{
                            required: true,
                        }"
                        v-if="formData['add_description']"
                    />
                    <topic-component
                        v-for="(item, index) in itemsTopics"
                        :key="index"
                        :label="index === 0 ? 'tema' : `tema ${index + 1}`"
                        :name="`topic-${index}`"
                        :btnDelete="index > 0"
                        :topic="item"
                        :save="item.save"
                        @remove="itemsTopics.splice(index, 1)"
                        @save="onSaveTopic"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    tooltips="añadir tema"
                    icon="mdi-plus"
                    @click="addTopic"
                />
                <q-btn-component
                    tooltips="guardar"
                    icon="mdi-content-save-outline"
                    @click="save"
                    class="r-position"
                />
                <q-btn-component
                    color="red"
                    icon="mdi-close"
                    tooltips="cancelar"
                    v-close-popup
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "../../form/input/TextField.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import EditorField from "../../form/input/EditorField.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";
import {
    error,
    error500,
    errorValidation,
    success,
    warning,
} from "../../../helpers/notifications";
import axios from "axios";

defineOptions({
    name: "SectionAddComponent",
});

const props = defineProps({
    url: String,
    base: String,
    imgbase: String,
    roles: String,
    icons: String,
    btn_config: Object,
});

const $q = useQuasar();

const emits = defineEmits(["reload-sections"]);
const page = usePage();
const form = ref(null);
const showDialog = ref(false);

const formData = ref({});

const itemsTopics = ref([]);
const totalUploaded = ref(0);
const totalFailed = ref(0);
const totalSave = ref(0);
const totalCoverImage = ref(0);
const totalPrincipalVideo = ref(0);

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const newTopic = (reset) => {
    let topic = {
        id: null,
        name: null,
        description: null,
        descriptionAdd: false,
        src: `${page.props.public_path}images/icon/img-upload-black.png`,
        coverImage: null,
        resources: [],
        principalVideo: false,
        save: false,
        section_id: null,
    };
    if (reset) {
        itemsTopics.value = [topic];
    } else {
        itemsTopics.value.push(topic);
    }
};
const onBeforeShowDialog = () => {
    newTopic(true);
};

const onHide = () => {
    itemsTopics.value = [];
    formData.value = {};
    totalSave.value = 0;
};

const addTopic = () => {
    form.value.validate().then((success) => {
        if (success) {
            newTopic(false);
        } else {
            error("rectifique los errores antes de agregar un nuevo tema");
        }
    });
};

const save = async () => {
    form.value.validate().then(async (success) => {
        if (success) {
            let show_confirm = false;
            let topics = itemsTopics.value;
            for (let i = 0; i < topics.length; i++) {
                if (
                    topics[i].coverImage === null ||
                    !topics[i].principalVideo
                ) {
                    show_confirm = true;
                    break;
                }
            }
            if (show_confirm) {
                $q.dialog({
                    title: "confirmacion",
                    html: true,
                    message: `<div class="text-center"><i class="fas fa-exclamation-triangle text-red" style="font-size: 62px;"></i></div><div style="text-align: justify;">existen temas que no estan configurados correctamente; recuerde que el tema no se mostrara de forma adecuada si:</div><div><ol><li style="text-align: justify;">no se establece la imagen de portada</li><li style="text-align: justify;">no tiene video principal ni al menos un adjunto</li></ol></div><div style="text-align: justify;">si desea continuar puede corregir los temas en el apartado <img src="${page.props.public_path}images/icon/black-edit.png" style="font-size: 1rem; width: 20px !important;">&nbsp;modificar seccion</div>`,
                    cancel: {
                        label: "cancelar",
                        icon: "mdi-cancel",
                        "no-caps": true,
                    },
                    ok: {
                        label: "si",
                        icon: "mdi-check",
                        color: "red",
                        "no-caps": true,
                    },
                    persistent: true,
                }).onOk(() => {
                    createSection();
                });
            } else {
                createSection();
            }
        } else {
            errorValidation();
        }
    });
};

const createSection = async () => {
    Loading.show({
        message: "adicionando seccion",
    });
    await axios
        .post("/admin/life", formData.value)
        .then((response) => {
            itemsTopics.value.forEach((topic) => {
                topic.section_id = response.data.id;
                topic.save = true;
            });
            Loading.show({
                message: "adicionando temas a la seccion",
            });
        })
        .catch((err) => {
            if (err.response.data.errors) {
                error(
                    "ya existe una seccion con el nombre actual especificado"
                );
            }
            Loading.hide();
        });
};

const onSaveTopic = (info) => {
    let { uploaded, failed, total } = info;
    totalSave.value++;
    if (totalSave.value === itemsTopics.value.length) {
        Loading.hide();
        success("seccion adicionada correctamente");
        showDialog.value = false;
        router.reload();
    }
};
</script>
