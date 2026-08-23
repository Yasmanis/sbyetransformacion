<template>
    <Layout title="en los medios">
        <q-page padding>
            <div class="text-h4 text-uppercase text-white q-mb-md">posts</div>
            <course-template>
                <template #panel-left>
                    <articles-list-view
                        title="lo mas importante"
                        :articles="fixeds"
                        v-if="fixeds.length > 0"
                    />

                    <q-card class="q-mt-lg">
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
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import ArticlesListView from "../../components/others/ArticlesListView.vue";
import ImageReproductor from "../../components/others/ImageReproductor.vue";
import SelectField from "../../components/form/input/SelectField.vue";
import { computed, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useQuasar } from "quasar";

defineOptions({
    name: "NewsletterPage",
});

const page = usePage();
const $q = useQuasar();

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

const screen = computed(() => {
    return $q.screen;
});

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

const articles = computed(() => {
    return page.props.files
        .filter((f) => !f.is_after)
        .map((f) => {
            return getFormatArticle(f);
        });
});

const fixeds = computed(() => {
    return articles.value.filter((f) => f.fixed);
});

const afters = computed(() => {
    return page.props.files
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
