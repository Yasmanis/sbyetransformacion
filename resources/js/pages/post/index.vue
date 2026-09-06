<template>
    <Layout title="en los medios">
        <q-page padding>
            <div class="text-h4 text-uppercase text-white q-mb-md">posts</div>
            <course-template :view-panel-section="false">
                <template #add>
                    <section-add-component
                        :segment="segment"
                        title="añadir campañas y posts"
                        topic-title="publicacion"
                    />
                </template>
                <template #edit>
                    <!-- <section-edit-component
                        :segment="segment"
                        :skip="modules_skip"
                        :has_add="has_add"
                        :has_edit="has_edit"
                        :has_delete="has_delete"
                        v-if="
                            has_edit &&
                            (files.length > 0 ||
                                $page.props.sections.length > 0)
                        "
                    /> -->
                    .
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
                                        <q-item-label>
                                            categorias
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item
                                    v-for="c in categories"
                                    :key="`category-${c.id}`"
                                    clickable
                                    dense
                                >
                                    <q-item-section>
                                        <q-item-label>
                                            {{ c.name }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </template>
                <template #panel-bottom>
                    <q-table
                        grid
                        :rows="articles"
                        row-key="name"
                        v-model:pagination="pagination"
                        hide-pagination
                        v-if="articles.length > 0"
                    >
                        <template #item="props">
                            <div
                                class="q-pa-xs col-xs-12 col-sm-3 col-md-3 col-lg-2 col-xl-2 grid-style-transition"
                            >
                                <image-reproductor
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
import SectionComponent from "../../components/modules/plattforms/SectionComponent.vue";
import VideoComponent from "../../components/modules/school/VideoComponent.vue";
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getActiveModule } from "../../services/current_module.js";

defineOptions({
    name: "NewsletterPage",
});

const page = usePage();

const currentFile = ref(null);
const showVideo = ref(false);
const currentVideo = ref(null);
const showChat = ref(null);
const has_add = ref(false);
const has_edit = ref(false);
const has_delete = ref(false);

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
const segment = ref(null);

onMounted(() => {
    let course = page.props.course ?? null;
    if (!course) {
        const pathSegments = window.location.pathname.split("/");
        course = pathSegments.pop() || pathSegments[pathSegments.length - 2];
    } else {
        course = `cursos/${course}`;
    }

    segment.value = course;

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

    setDefaults();
});

const setDefaults = () => {
    const current_module = getActiveModule();
    const permissions = current_module.permissions.map((p) => p.name);
    const modelName = current_module.model.toLowerCase();
    has_add.value = permissions.includes(`add_${modelName}`);
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);
};

const files = computed(() => {
    return page.props?.files || [];
});

const articles = computed(() => {
    return files.value
        .filter((f) => !f.is_after)
        .map((f) => {
            return getFormatArticle(f);
        });
});

const fixeds = computed(() => {
    return articles.value.filter((f) => f.fixed);
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
</script>
