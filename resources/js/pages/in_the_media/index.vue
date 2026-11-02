<template>
    <Layout title="en los medios">
        <q-page padding>
            <div class="text-h4 text-uppercase text-white q-mb-md">
                en los medios
            </div>
            <course-template :view-panel-section="false">
                <template #panel-left>
                    <articles-list-view
                        title="articulos destacados"
                        :articles="fixeds"
                    />

                    <div class="q-pt-lg"></div>

                    <articles-list-view
                        title="proximos articulos"
                        :articles="afters"
                    />
                </template>
                <template #add="{ props }">
                    <section-add-component
                        :segment="props.segment"
                        title="añadir medio periodístico y articulos"
                        topic-title="articulo"
                        v-if="props.has_add"
                    />
                </template>
                <template #edit="{ props }">
                    <section-edit-component
                        :segment="props.segment"
                        :has_add="props.has_add"
                        :has_edit="props.has_edit"
                        :has_delete="props.has_delete"
                        title="modificar seccion y articulos"
                        topic-title="articulo"
                        v-if="props.has_edit && files.length > 0"
                    />
                </template>
                <template #panel-bottom>
                    <q-card>
                        <q-card-section>
                            <div class="q-mb-sm">subcategorias</div>
                            <div
                                class="row items-center"
                                v-if="$page.props.subcategories?.length > 0"
                            >
                                <div
                                    class="col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3"
                                    v-for="c in $page.props.subcategories"
                                    :key="`category-${c.id}`"
                                    :active="currentSucategory?.id === c.id"
                                    @click="onClickSubcategory(c)"
                                >
                                    <span class="cursor-pointer">{{
                                        c.name
                                    }}</span>
                                </div>
                            </div>
                            <p class="q-pa-md text-caption text-center" v-else>
                                no existen subcategorias disponibles
                            </p>
                        </q-card-section>
                    </q-card>
                    <q-table
                        grid
                        :rows="articles"
                        row-key="name"
                        v-model:pagination="pagination"
                        hide-pagination
                        class="q-mt-md"
                        v-if="articles.length > 0"
                    >
                        <template #item="props">
                            <div
                                class="q-pa-xs col-xs-12 col-sm-3 col-md-3 col-lg-2 col-xl-2 grid-style-transition"
                            >
                                <image-reproductor
                                    glightbox
                                    :src="props.row.image"
                                    :reproductor="
                                        props.row.file_type === 'video'
                                    "
                                    @click="
                                        () => {
                                            currentFile = props.row;
                                            startVideo(props.row);
                                        }
                                    "
                                />
                            </div>
                        </template>
                    </q-table>
                    <q-item>
                        <q-item-section />
                        <q-item-section avatar>
                            <q-select
                                v-model="pagination.rowsPerPage"
                                dense
                                options-dense
                                emit-value
                                map-options
                                filled
                                standout
                                square
                                bg-color="white"
                                :options="options"
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <q-pagination
                                v-model="pagination.page"
                                text-color="white"
                                active-color="dark"
                                :max="pagesNumber"
                                :max-pages="4"
                                :boundary-numbers="false"
                                direction-links
                            />
                        </q-item-section>
                    </q-item>
                </template>

                <template #current-info>
                    <section-component
                        :topic="currentFile"
                        :show-chat="showChat"
                        @play="startVideo"
                    />
                </template>
            </course-template>
        </q-page>
    </Layout>

    <video-component
        :show="showVideo"
        :video="currentVideo"
        :topic="currentFile"
        @close="showVideo = false"
    />
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import CourseTemplate from "../../components/others/CourseTemplate.vue";
import ArticlesListView from "../../components/others/ArticlesListView.vue";
import ImageReproductor from "../../components/others/ImageReproductor.vue";
import SectionAddComponent from "../../components/modules/plattforms/SectionAddComponent.vue";
import SectionEditComponent from "../../components/modules/plattforms/SectionEditComponent.vue";

import VideoComponent from "../../components/modules/school/VideoComponent.vue";
import SectionComponent from "../../components/modules/plattforms/SectionComponent.vue";

import {
    computed,
    nextTick,
    onBeforeUnmount,
    onMounted,
    ref,
    watch,
} from "vue";
import { usePage } from "@inertiajs/vue3";

import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";

defineOptions({
    name: "NewsletterPage",
});

const page = usePage();

const pagination = ref({
    sortBy: "desc",
    descending: false,
    page: 1,
    rowsPerPage: 6,
});

const currentFile = ref(null);
const showVideo = ref(false);
const currentVideo = ref(null);
const showChat = ref(null);
const currentSucategory = ref(null);

const options = [
    {
        label: "5",
        value: 5,
    },
    {
        label: "10",
        value: 10,
    },
    {
        label: "20",
        value: 20,
    },
    {
        label: "30",
        value: 30,
    },
    {
        label: "50",
        value: 50,
    },
    {
        label: "100",
        value: 100,
    },
    {
        label: "todas",
        value: Number.MAX_VALUE,
    },
];

const pagesNumber = computed(() =>
    Math.ceil(articles.value.length / pagination.value.rowsPerPage),
);

const categories = ref([
    {
        id: 1,
        name: "inconsciente",
    },
    {
        id: 2,
        name: "programacion",
    },
    {
        id: 3,
        name: "dependencia emocional",
    },
]);

let lightbox = null;

onMounted(() => {
    const hash = location.hash;
    if (hash) {
        showChat.value = hash.substring(1);
        const segments = hash.split("-"),
            found = files.value.find(
                (f) => Number(f.id) === Number(segments[2]),
            );
        currentFile.value = found;
    } else {
        currentFile.value = files.value.length > 0 ? files.value[0] : null;
    }

    nextTick(() => {
        refreshLightbox();
    });
});

onBeforeUnmount(() => {
    if (lightbox) {
        lightbox.destroy();
        lightbox = null;
    }
});

watch(
    () => [pagination.value.page, pagination.value.rowsPerPage],
    () => {
        refreshLightbox();
    },
);

const refreshLightbox = () => {
    nextTick(() => {
        if (lightbox) {
            lightbox.reload();
        } else {
            lightbox = GLightbox({
                selector: ".glightbox",
                touchNavigation: true,
                loop: false,
            });
        }
    });
};

const files = computed(() => {
    return page.props?.files || [];
});

const articles = computed(() => {
    return (
        files.value
            .filter((f) => !f.is_after)
            .map((f) => {
                return getFormatArticle(f);
            }) || []
    );
});

const fixeds = computed(() => {
    return articles.value.filter((f) => f.fixed);
});

const afters = computed(() => {
    return files.value
        .filter((f) => f.is_after)
        .map((f) => {
            return getFormatArticle(f);
        });
});

const getFormatArticle = (f) => {
    let image = f.path;
    if (f.file_type === "video") {
        image = f.poster;
    }
    return {
        title: f.name,
        description: f.description ?? null,
        image: `${page.props.public_path}storage/${image}`,
        ...f,
    };
};

const startVideo = (file) => {
    if (file.file_type === "video") {
        currentVideo.value = file;
        showVideo.value = true;
    }
};

const onClickSubcategory = (s) => {
    if (s.id === currentSucategory.value?.id) {
        currentSucategory.value = null;
    } else {
        currentSucategory.value = s;
    }
};
</script>
