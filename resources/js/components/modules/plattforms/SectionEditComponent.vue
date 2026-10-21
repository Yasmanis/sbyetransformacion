<template>
    <btn-edit-component
        tooltips="modificar seccion y publicaciones"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent full-width>
        <q-card>
            <dialog-header-component
                :icon="`img:${page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-edit.png`"
                title="modificar seccion y publicaciones"
                closable
                @close="showDialog = false"
            >
                <template #actions v-if="module">
                    <sort-elements-component
                        tooltips="ordenar secciones"
                        model="SchoolSection"
                        has-fixed
                        :filter-columns="{
                            module_id: module.id,
                        }"
                        :sorted-columns="{
                            fixed: 'desc',
                            order: 'asc',
                        }"
                    />

                    <sort-elements-time-component
                        :object="module"
                        :tooltips="
                            module?.sort_sections
                                ? 'cambiar orden de secciones por fecha'
                                : 'establecer orden de secciones por fecha'
                        "
                        model="Module"
                        model-child="SchoolSection"
                        parent-column-child="module_id"
                        sort-column="sort_sections"
                    />
                </template>
            </dialog-header-component>

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
                                tooltips="adicionar publicacion"
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
                                tooltips="ordenar publicaciones"
                                :filter-columns="{
                                    section_id: s.id,
                                    principal: 1,
                                }"
                                :sorted-columns="{
                                    fixed: 'desc',
                                    order: 'asc',
                                }"
                                has-fixed
                                model="File"
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
                        v-for="(topic, indexTopic) in files.filter(
                            (f) => f.section_id === s.id,
                        )"
                        :key="indexTopic"
                    >
                        <cart-article :article="topic" />
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
                <q-list>
                    <q-item class="q-pb-none">
                        <q-item-section>
                            <q-item-label class="text-bold">
                                no definida
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar v-if="has_edit">
                            <sort-elements-component
                                tooltips="ordenar publicaciones"
                                :filter-columns="{
                                    section_id: null,
                                    category_id: $page.props.category.id,
                                    principal: 1,
                                }"
                                :sorted-columns="{
                                    fixed: 'desc',
                                    order: 'asc',
                                }"
                                has-fixed
                                model="File"
                            />
                        </q-item-section>
                    </q-item>
                    <q-item
                        v-for="(topic, indexTopic) in files.filter(
                            (f) => f.section_id === null,
                        )"
                        :key="indexTopic"
                    >
                        <cart-article :article="topic" />
                        <q-item-section avatar v-if="has_edit">
                            <btn-edit-component
                                tooltips="editar publicacion"
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
                                tooltips="eliminar publicacion"
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
        @before-show="onBeforeShowDialogTopic"
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
                :title="
                    currentTopic
                        ? 'editar publicacion'
                        : 'adicionar publicacion'
                "
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
                                index === 0
                                    ? 'publicacion'
                                    : `publicacion ${getIndex(item)}`
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
                    tooltips="adicionar nueva publicacion"
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
        :message="`seguro que deseas eliminar el articulo <b>${currentTopic?.name}</b>`"
        @hide="confirmTopic = false"
        @ok="
            router.delete(`/admin/files/${currentTopic.id}`, {
                onSuccess: () => (confirmTopic = false),
            })
        "
    />
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import TopicComponent from "./topic/TopicComponent.vue";
import SectionFormComponent from "./SectionFormComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import SortElementsComponent from "../../others/SortElementsComponent.vue";
import SortElementsTimeComponent from "../../others/SortElementsTimeComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";

import CartArticle from "./CartArticle.vue";
import { usePage, router } from "@inertiajs/vue3";
import { useQuasar, Loading, Dark, date } from "quasar";
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

const fields = [
    {
        field: "name",
        name: "name",
        label: "nombre",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
        othersProps: {
            required: true,
        },
    },
    {
        field: "link",
        name: "link",
        label: "link",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
        othersProps: {
            required: true,
        },
    },
    {
        type: "dynamicselects",
        fields: [
            {
                name: "category_id",
                label: "categoria",
                dependsOn: [],
                url: "/categories",
                method: "get",
                options: [],
                value: null,
                loading: false,
                disabled: true,
                resets: ["subcategory_id"],
                type: "select",
                scope: "whereCategory",
                rules: ["required"],
            },
            {
                name: "subcategory_id",
                label: "subcategoria",
                dependsOn: ["category_id"],
                url: "/publications-categories",
                method: "post",
                options: [],
                value: null,
                loading: false,
                disabled: true,
                resets: [],
                type: "select",
                scope: "whereSubcategory",
                rules: ["required"],
            },
        ],
    },

    {
        field: "public_access",
        name: "public_access",
        label: "acceso publico",
        align: "center",
        type: "boolean",
        othersProps: {
            help: [
                "marque esta casilla si desea que el/los fichero(s) tengan acceso publico",
            ],
        },
    },
    {
        field: "public_date",
        name: "public_date",
        label: "publicacion",
        type: "date",
        sortable: true,
        align: "left",
    },
    {
        field: "file",
        name: "file",
        label: "archivo",
        type: "file",
        sortable: true,
        align: "left",
        othersProps: {
            icon: "mdi-file-outline",
            change: true,
            helpCheck:
                "marque esta casilla si desea reemplazar el fichero existente",
        },
    },
];

const sections = computed(() => {
    return page.props.sections || [];
});

const files = computed(() => page.props.files);

const module = computed(() => page.props.module);

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
        section_id: currentSection.value?.id || null,
        isOk: false,
        visible: true,
        index: index.value,
        book_volume: null,
        visible_after_testimony: false,
        skip: false,
        category_id: page.props?.category?.id || null,
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
            saveNewTopic();
        } else {
            errorValidation();
        }
    });
};

const saveNewTopic = () => {
    Loading.show({
        message: "adicionando articulos a la seccion",
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
                        ? "articulos adicionados"
                        : "articulo adicionado"
                } correctamente`,
            );
        } else {
            success("articulo modificado correctamente");
        }
        showDialogTopic.value = false;
        router.reload();
    }
};

const onBeforeShowDialogTopic = () => {
    newTopic(true);
    totalSave.value = 0;
    if (currentTopic.value) {
        itemsTopics.value.forEach((t) => {
            t.isOk =
                currentTopic.value.poster !== null &&
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
