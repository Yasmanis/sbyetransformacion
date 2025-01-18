<template>
    <q-btn-component
        tooltips="adicionar seccion"
        icon="mdi-plus"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
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
                    <section-form-component
                        :save="saveSection"
                        @store="onStoreSection"
                        @error="saveSection = false"
                    />
                    <template v-for="(item, index) in itemsTopics" :key="index">
                        <topic-component
                            :label="
                                index === 0 ? 'tema' : `tema ${getIndex(item)}`
                            "
                            :name="`topic-${index}`"
                            :btnDelete="index > 0"
                            :topic="item"
                            :save="item.save"
                            @remove="
                                () => {
                                    item.visible = false;
                                    itema.name = 'topic oculto';
                                }
                            "
                            @save="onSaveTopic"
                            @is-ok="
                                (ok) => {
                                    item.isOk = ok;
                                }
                            "
                            v-if="item.visible"
                        />
                    </template>
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
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import SectionFormComponent from "./section/SectionFormComponent.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { usePage, router } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";

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
const saveSection = ref(false);
const itemsTopics = ref([]);
const totalSave = ref(0);
const index = ref(0);

const newTopic = (reset) => {
    index.value++;
    let topic = {
        id: null,
        name: null,
        description: null,
        descriptionAdd: false,
        coverImage: null,
        resources: [],
        principalVideo: false,
        save: false,
        section_id: null,
        isOk: false,
        visible: true,
        index: index.value,
        book_volume: null,
        visible_after_testimony: false,
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
            let show_confirm = itemsTopics.value.find(
                (t) => !t.isOk && t.visible
            );
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
                    saveSection.value = true;
                });
            } else {
                saveSection.value = true;
            }
        } else {
            errorValidation();
        }
    });
};

const onStoreSection = (id) => {
    saveSection.value = false;
    itemsTopics.value.forEach((topic) => {
        topic.section_id = id;
        topic.save = true;
    });
    Loading.show({
        message: "adicionando temas a la seccion",
    });
};

const onSaveTopic = (info) => {
    totalSave.value++;
    if (totalSave.value === itemsTopics.value.filter((t) => t.visible).length) {
        Loading.hide();
        success("seccion adicionada correctamente");
        showDialog.value = false;
        router.reload();
    }
};

const getIndex = (t) => {
    let visibles = itemsTopics.value.filter((t) => t.visible);
    return visibles.findIndex((v) => v.index === t.index) + 1;
};
</script>
