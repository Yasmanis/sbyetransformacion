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
                        v-if="fixeds.length > 0"
                    />

                    <div class="q-pt-lg"></div>

                    <articles-list-view
                        title="proximos articulos"
                        :articles="afters"
                        v-if="afters.length > 0"
                    />
                </template>
                <template #add>
                    <!-- <section-add-component
                        :segment="segment"
                        title="añadir medio periodístico y articulos"
                    /> -->
                    .
                </template>
                <template #edit>
                    <!-- <section-add-component
                        :segment="segment"
                        title="añadir medio periodístico y articulos"
                    /> -->
                    .
                </template>
                <template #panel-bottom>
                    <q-card>
                        <q-card-section>
                            <div class="q-mb-sm">categorias</div>
                            <div class="row items-center">
                                <div
                                    class="col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3"
                                    v-for="c in categories"
                                    :key="`category-${c.id}`"
                                >
                                    <span class="cursor-pointer">{{
                                        c.name
                                    }}</span>
                                </div>
                            </div>
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
                                    :src="props.row.image"
                                    :reproductor="
                                        props.row.file_type === 'video'
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
            </course-template>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import CourseTemplate from "../../components/others/CourseTemplate.vue";
import ArticlesListView from "../../components/others/ArticlesListView.vue";
import ImageReproductor from "../../components/others/ImageReproductor.vue";
import SectionAddComponent from "../../components/modules/plattforms/SectionAddComponent.vue";
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "NewsletterPage",
});

const page = usePage();

const pagination = ref({
    sortBy: "desc",
    descending: false,
    page: 2,
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
});

const files = computed(() => {
    return page.props?.category?.files || [];
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
</script>
