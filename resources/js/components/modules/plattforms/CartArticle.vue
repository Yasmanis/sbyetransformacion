<template>
    <q-item-section avatar>
        <image-reproductor
            :src="`${page.props.public_path}storage/${article.file_type === 'image' ? article.path : article.poster}`"
            :reproductor="article.file_type === 'video'"
            :ratio="1"
            width="100px"
        />
    </q-item-section>
    <q-item-section>
        <q-item-label class="resource-title text-bold">
            {{ article.name }}
        </q-item-label>
        <q-item-label caption>
            <b>publico: </b
            ><q-chip
                dense
                size="sm"
                style="max-width: min-content"
                :color="article.public_access ? 'black' : 'blue-2'"
                :text-color="article.public_access ? 'white' : 'black'"
                :icon="article.public_access ? 'check' : 'error'"
                :label="article.public_access ? 'Si' : 'No'"
            />
        </q-item-label>
        <q-item-label caption>
            <b>publicacion: </b>
            {{
                article.public_date
                    ? date.formatDate(article.public_date, "DD/MM/YYYY")
                    : "-"
            }}</q-item-label
        >
        <q-item-label>{{ article.subcategory_str }}</q-item-label>
        <q-item-label
            class="resource-title"
            v-if="article.file_type === 'video'"
        >
            <q-icon name="mdi-video"></q-icon>
        </q-item-label>
    </q-item-section>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { date } from "quasar";
import ImageReproductor from "../../others/ImageReproductor.vue";

defineOptions({
    name: "CartArticle",
});

const props = defineProps({
    article: Object,
});

const page = usePage();
</script>
