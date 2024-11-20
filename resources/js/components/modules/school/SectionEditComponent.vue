<template>
    <btn-edit-component
        tooltips="modificar seccion y temas"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent full-width>
        <q-card>
            <dialog-header-component
                :icon="`img:${page.props.public_path}images/icon/black-edit.png`"
                title="modificar seccion y temas"
                closable
            />
            <q-card-section
                class="col q-pt-none scroll"
                style="max-height: 60vh"
            >
                <q-list
                    v-for="(s, index) in sections"
                    :key="`section-${index}`"
                >
                    <q-item class="q-pb-none">
                        <q-item-section>
                            <q-item-label class="text-bold">
                                {{ s.name }}
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-edit-component
                                tooltips="editar seccion"
                                @click="
                                    () => {
                                        showDialogSection = true;
                                        currentSection = s;
                                    }
                                "
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <q-btn-component
                                icon="mdi-plus"
                                tooltips="adicionar tema"
                                @click="
                                    () => {
                                        currentSection = s;
                                        showDialogTopic = true;
                                    }
                                "
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <q-btn-component
                                icon="mdi-trash-can-outline"
                                tooltips="eliminar seccion"
                                color="red"
                                @click="sectionRemove(s)"
                            />
                        </q-item-section>
                    </q-item>
                    <q-item
                        v-for="(topic, indexTopic) in s.topics"
                        :key="indexTopic"
                    >
                        <q-item-section avatar>
                            <q-img
                                :src="`${page.props.public_path}storage/${topic.coverImage}`"
                                style="
                                    height: 60px;
                                    width: 60px;
                                    border: 1px solid lightgray;
                                "
                            >
                                <div
                                    class="absolute-full text-subtitle2 flex flex-center"
                                >
                                    <q-btn-component
                                        :tooltips="
                                            !topic.has_principal_video
                                                ? ''
                                                : 'reproducir'
                                        "
                                        icon="fab fa-youtube"
                                        :disabled="!topic.has_principal_video"
                                    />
                                </div>
                                <template v-slot:error>
                                    <div
                                        class="absolute-full flex flex-center bg-negative text-white"
                                    >
                                        error
                                    </div>
                                </template>
                            </q-img>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label class="resource-title">{{
                                topic.name
                            }}</q-item-label>
                            <q-item-label class="resource-title">
                                <q-icon name="mdi-video"></q-icon>
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-edit-component
                                tooltips="editar tema"
                                @click="
                                    () => {
                                        currentSection = s;
                                        currentTopic = topic;
                                        showDialogTopic = true;
                                    }
                                "
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <q-btn-component
                                icon="mdi-trash-can-outline"
                                tooltips="eliminar tema"
                                color="red"
                                @click="topicRemove(topic)"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    label="cancelar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    color="red"
                    no_caps
                    icon="mdi-close-circle-outline"
                    v-close-popup
                />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog
        v-model="showDialogTopic"
        persistent
        @before-show="onBeforeShow"
        @hide="currentTopic = null"
    >
        <q-card style="width: 800px">
            <dialog-header-component
                :icon="
                    currentTopic
                        ? `img:${$page.props.public_path}images/icon/black-edit.png`
                        : 'mdi-plus'
                "
                :title="currentTopic ? 'editar tema' : 'adicionar tema'"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="formTopic" greedy>
                    <topic-component
                        v-for="(item, index) in itemsTopics"
                        :key="index"
                        :label="index === 0 ? 'tema' : `tema ${index + 1}`"
                        :name="`topic-${index}`"
                        :btnDelete="index > 0"
                        :topic="currentTopic ? currentTopic : item"
                        :save="item.save"
                        @remove="itemsTopics.splice(index, 1)"
                        @save="onSaveTopic"
                        @update="
                            () => {
                                item.save = false;
                                showDialogTopic = false;
                            }
                        "
                        @is-ok="
                            (ok) => {
                                item.isOk = ok;
                            }
                        "
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    tooltips="añadir tema"
                    icon="mdi-plus"
                    @click="addTopic"
                    v-if="!currentTopic"
                />
                <q-btn-component
                    tooltips="guardar"
                    icon="mdi-content-save-outline"
                    @click="saveTopic"
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

    <q-dialog v-model="showDialogSection" persistent>
        <q-card style="width: 800px">
            <dialog-header-component
                :icon="`img:${page.props.public_path}images/icon/black-edit.png`"
                title="editar seccion"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="formSection" greedy>
                    <section-form-component
                        :save="saveSection"
                        :object="currentSection"
                        @update="
                            () => {
                                saveSection = false;
                                showDialogSection = false;
                            }
                        "
                        @error="saveSection = false"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    label="guardar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    no_caps
                    icon="mdi-content-save-outline"
                    @click="updateSection"
                />
                <q-btn-component
                    label="cancelar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    color="red"
                    no_caps
                    icon="mdi-close-circle-outline"
                    v-close-popup
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import SectionFormComponent from "./section/SectionFormComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";
import {
    error,
    error500,
    errorValidation,
    success,
    warning,
} from "../../../helpers/notifications";

defineOptions({
    name: "SectionEditComponent",
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
const showDialog = ref(false);
const showDialogTopic = ref(false);
const showDialogSection = ref(false);
const itemsTopics = ref([]);
const totalSave = ref(0);
const formTopic = ref(null);
const formSection = ref(null);
const currentSection = ref(null);
const currentTopic = ref(null);
const saveSection = ref(false);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

const newTopic = (reset) => {
    let topic = {
        id: null,
        name: null,
        description: null,
        descriptionAdd: false,
        coverImage: null,
        resources: [],
        principalVideo: false,
        save: false,
        section_id: currentSection.value.id,
        isOk: false,
    };
    if (reset) {
        itemsTopics.value = [topic];
    } else {
        itemsTopics.value.push(topic);
    }
};

const sectionRemove = (s) => {
    $q.dialog({
        title: "confirmacion",
        html: true,
        message: `seguro que deseas eliminar la seccion <b>${s.name}</b>`,
        cancel: {
            label: "cancelar",
            icon: "mdi-cancel",
        },
        ok: {
            label: "si",
            icon: "mdi-check",
            color: "red",
        },
        persistent: true,
    }).onOk(() => {
        const send = useForm({});
        send.delete(`/admin/life/${s.id}`);
    });
};

const topicRemove = (t) => {
    $q.dialog({
        title: "confirmacion",
        html: true,
        message: `seguro que deseas eliminar el tema <b>${t.name}</b>`,
        cancel: {
            label: "cancelar",
            icon: "mdi-cancel",
        },
        ok: {
            label: "si",
            icon: "mdi-check",
            color: "red",
        },
        persistent: true,
    }).onOk(() => {
        const send = useForm({});
        send.delete(`/admin/schooltopics/${t.id}`);
    });
};

const addTopic = () => {
    formTopic.value.validate().then((success) => {
        if (success) {
            newTopic(false);
        } else {
            error("rectifique los errores antes de agregar un nuevo tema");
        }
    });
};

const saveTopic = async () => {
    formTopic.value.validate().then(async (success) => {
        if (success) {
            let show_confirm = itemsTopics.value.find((t) => t.isOk === false);
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
                    saveNewTopic();
                });
            } else {
                saveNewTopic();
            }
        } else {
            errorValidation();
        }
    });
};

const saveNewTopic = () => {
    Loading.show({
        message: "adicionando temas a la seccion",
    });
    itemsTopics.value.forEach((topic) => {
        topic.save = true;
    });
};

const onSaveTopic = (info, store) => {
    let { uploaded, failed, total } = info;
    totalSave.value++;
    if (totalSave.value === itemsTopics.value.length) {
        Loading.hide();
        if (store) {
            success(
                `${
                    totalSave.value > 1
                        ? "temas adicionados"
                        : "tema adicionado"
                } correctamente`
            );
        } else {
            success("tema modificado correctamente");
        }
        showDialogTopic.value = false;
        router.reload();
    }
};

const onBeforeShow = () => {
    newTopic(true);
    totalSave.value = 0;
    if (currentTopic.value) {
        itemsTopics.value.forEach((t) => {
            t.isOk =
                currentTopic.value.coverImage !== null &&
                currentTopic.value.has_principal_video;
        });
    }
};

const updateSection = () => {
    formSection.value.validate().then((success) => {
        if (success) {
            saveSection.value = true;
        } else {
            errorValidation();
        }
    });
};
</script>
