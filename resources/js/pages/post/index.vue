<template>
    <Layout title="en los medios">
        <q-page padding>
            <div class="text-h4 text-uppercase text-white q-mb-md">posts</div>
            <course-template :view-panel-section="false">
                <template #add="{ props }">
                    <section-add-component
                        :segment="props.segment"
                        title="añadir campañas y posts"
                        topic-title="publicacion"
                        v-if="props.has_add"
                    />
                </template>
                <template #edit="{ props }">
                    <section-edit-component
                        :segment="props.segment"
                        :has_add="props.has_add"
                        :has_edit="props.has_edit"
                        :has_delete="props.has_delete"
                        v-if="props.has_edit && files.length > 0"
                    />
                </template>
                <template #panel-left>
                    <articles-list-view
                        title="lo mas importante"
                        :articles="fixeds"
                        v-if="fixeds.length > 0"
                    />

                    <q-card>
                        <q-card-section class="no-padding">
                            <q-list>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-bold">
                                            subcategorias
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <template
                                    v-if="$page.props.subcategories?.length > 0"
                                >
                                    <q-item
                                        v-for="c in $page.props.subcategories ||
                                        []"
                                        :key="`category-${c.id}`"
                                        clickable
                                        dense
                                        :active="currentSucategory?.id === c.id"
                                        @click="onClickSubcategory(c)"
                                    >
                                        <q-item-section>
                                            <q-item-label>
                                                {{ c.name }}
                                            </q-item-label>
                                        </q-item-section>
                                    </q-item>
                                </template>

                                <p class="q-pa-md text-caption" v-else>
                                    no existen subcategorias disponibles
                                </p>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </template>
                <template #panel-bottom>
                    <template v-if="articles.length > 0">
                        <q-table
                            grid
                            :rows="articles"
                            row-key="id"
                            v-model:pagination="pagination"
                            hide-pagination
                            @update:pagination="refreshLightbox"
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
                    <p class="text-white text-center text-h6" v-else>
                        aun no existen publicaciones de esta subcategoria
                    </p>
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
import SectionComponent from "../../components/modules/plattforms/SectionComponent.vue";
import VideoComponent from "../../components/modules/school/VideoComponent.vue";
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

const currentFile = ref(null);
const showVideo = ref(false);
const currentVideo = ref(null);
const showChat = ref(null);
const currentSucategory = ref(null);

const pagination = ref({
    sortBy: "desc",
    descending: false,
    page: 1,
    rowsPerPage: 6,
});

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

const files = computed(() => page.props?.files || []);

const allArticles = computed(() =>
    files.value
        .filter((f) => !f.is_after)
        .map((f) => {
            return getFormatArticle(f);
        }),
);

const articles = computed(() =>
    currentSucategory.value
        ? allArticles.value.filter(
              (l) => l.subcategory_id === currentSucategory.value.id,
          )
        : allArticles.value,
);

const fixeds = computed(() => {
    return allArticles.value.filter((f) => f.fixed);
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
