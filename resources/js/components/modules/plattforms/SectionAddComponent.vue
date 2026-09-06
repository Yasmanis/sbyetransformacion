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
                :title="title"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <section-form-component
                        :save="saveSection"
                        :segment="segment"
                        @store="onStoreSection"
                        @error="saveSection = false"
                    />
                    <template v-for="(item, index) in itemsTopics" :key="index">
                        <topic-component
                            :principal-file-title="principalFileTitle"
                            :segment="segment"
                            :skip="skip"
                            :label="
                                index === 0
                                    ? topicTitle
                                    : `${topicTitle} ${getIndex(item)}`
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
import SectionFormComponent from "./SectionFormComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import { usePage, router } from "@inertiajs/vue3";
import { Loading } from "quasar";
import {
    error,
    errorValidation,
    success,
} from "../../../helpers/notifications";

defineOptions({
    name: "SectionAddComponent",
});

const props = defineProps({
    segment: String,
    title: String,
    principalFileTitle: {
        type: String,
        default: "publicacion principal",
    },
    topicTitle: {
        type: String,
        default: "tema",
    },
    skip: {
        type: Array,
        default: [],
    },
});

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
        poster: null,
        resources: [],
        principalVideo: false,
        save: false,
        section_id: null,
        visible: true,
        index: index.value,
        category_id: page.props?.category?.id || null,
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
    saveSection.value = false;
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
            saveSection.value = true;
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
