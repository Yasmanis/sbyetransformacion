<template>
    <btn-edit-component
        tooltips="modificar seccion y temas"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent full-width>
        <q-card>
            <dialog-header-component
                :icon="`img:${page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-edit.png`"
                title="modificar seccion y temas"
                closable
                @close="showDialog = false"
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
                        <q-item-section avatar v-if="has_edit">
                            <btn-add-component
                                tooltips="adicionar tema"
                                @click="
                                    () => {
                                        currentSection = s;
                                        showDialogTopic = true;
                                    }
                                "
                            />
                        </q-item-section>
                        <q-item-section avatar v-if="has_edit">
                            <sort-elements-component
                                tooltips="ordenar temas"
                                :items="s.topics"
                                url="/admin/schooltopics/sort-topics"
                            />
                        </q-item-section>
                        <q-item-section avatar v-if="has_delete">
                            <btn-delete-component
                                tooltips="eliminar seccion"
                                @click="
                                    () => {
                                        currentSection = s;
                                        confirmSection = true;
                                    }
                                "
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
                                        color="primary"
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
                        <q-item-section avatar v-if="has_edit">
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
                        <q-item-section avatar v-if="has_edit">
                            <btn-delete-component
                                tooltips="eliminar tema"
                                @click="
                                    () => {
                                        currentTopic = topic;
                                        confirmTopic = true;
                                    }
                                "
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog
        v-model="showDialogTopic"
        persistent
        allow-focus-outside
        @before-show="onBeforeShow"
        @hide="currentTopic = null"
    >
        <q-card style="width: 800px">
            <dialog-header-component
                :icon="
                    currentTopic
                        ? `img:${$page.props.public_path}images/icon/${
                              Dark.isActive ? 'white' : 'black'
                          }-edit.png`
                        : 'mdi-plus'
                "
                :title="currentTopic ? 'editar tema' : 'adicionar tema'"
                closable
                @close="showDialogTopic = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="formTopic" greedy>
                    <template v-for="(item, index) in itemsTopics" :key="index">
                        <topic-component
                            :segment="segment"
                            :skip="skip"
                            :label="
                                index === 0 ? 'tema' : `tema ${getIndex(item)}`
                            "
                            :name="`topic-${index}`"
                            :btnDelete="index > 0"
                            :topic="currentTopic ? currentTopic : item"
                            :save="item.save"
                            @remove="
                                () => {
                                    item.visible = false;
                                    item.name = 'tema oculto';
                                }
                            "
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
                            v-if="item.visible"
                        />
                    </template>
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-add-component
                    tooltips="adicionar nuevo tema"
                    @click="addTopic"
                    v-if="!currentTopic"
                />
                <btn-save-component @click="saveTopic" />
                <btn-cancel-component @click="showDialogTopic = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="showDialogSection" persistent allow-focus-outside>
        <q-card style="width: 800px">
            <dialog-header-component
                :icon="`img:${page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-edit.png`"
                title="editar seccion"
                closable
                @close="showDialogSection = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="formSection" greedy>
                    <section-form-component
                        :save="saveSection"
                        :object="currentSection"
                        :segment="segment"
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
                <btn-save-component @click="updateSection" />
                <btn-cancel-component @click="showDialogSection = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <confirm-component
        :show="confirmSection"
        :message="`seguro que deseas eliminar la seccion <b>${currentSection?.name}</b>`"
        @hide="confirmSection = false"
        @ok="
            router.delete(`/admin/school/${currentSection.id}`, {
                onSuccess: () => (confirmSection = false),
            })
        "
    />
    <confirm-component
        :show="confirmTopic"
        :message="`seguro que deseas eliminar el tema <b>${currentTopic?.name}</b>`"
        @hide="confirmTopic = false"
        @ok="
            router.delete(`/admin/schooltopics/${currentTopic.id}`, {
                onSuccess: () => (confirmTopic = false),
            })
        "
    />
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import SectionFormComponent from "./section/SectionFormComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import SortElementsComponent from "../../others/SortElementsComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import { usePage, router } from "@inertiajs/vue3";
import { useQuasar, Loading, Dark } from "quasar";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";

defineOptions({
    name: "SectionEditComponent",
});

const props = defineProps({
    has_add: {
        type: Boolean,
        default: false,
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
    has_delete: {
        type: Boolean,
        default: false,
    },
    segment: String,
    skip: {
        type: Array,
        default: [],
    },
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
const index = ref(0);
const confirmSection = ref(false);
const confirmTopic = ref(false);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

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
        section_id: currentSection.value.id,
        isOk: false,
        visible: true,
        index: index.value,
        book_volume: null,
        visible_after_testimony: false,
        skip: false,
    };
    if (reset) {
        itemsTopics.value = [topic];
    } else {
        itemsTopics.value.push(topic);
    }
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
        if (topic.visible) {
            topic.save = true;
        }
    });
};

const onSaveTopic = (info, store) => {
    let { uploaded, failed, total } = info;
    totalSave.value++;
    if (totalSave.value === itemsTopics.value.filter((t) => t.visible).length) {
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

const getIndex = (t) => {
    let visibles = itemsTopics.value.filter((t) => t.visible);
    return visibles.findIndex((v) => v.index === t.index) + 1;
};
</script>
