<template>
    <q-card flat bordered class="my-card">
        <q-card-section v-if="title">
            <div class="text-h6 text-bold">{{ title }}</div>
        </q-card-section>
        <q-card-section class="q-pa-xs scroll" style="max-height: 400px">
            <q-card-section
                v-for="a in articles"
                :key="`article-${a.id}`"
                :horizontal="screen.gt.md"
                class="q-my-xs"
            >
                <div
                    class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 self-center"
                >
                    <image-reproductor
                        :src="a.image"
                        :reproductor="a.file_type === 'video'"
                    />
                </div>
                <q-card-section class="q-py-none self-center">
                    <div class="text-subtitle1" v-if="a.title">
                        {{ a.title }}
                    </div>
                    <div
                        class="text-body1"
                        style="font-size: 15px"
                        v-if="a.description"
                    >
                        {{ a.description }}
                    </div>
                </q-card-section>
            </q-card-section>
        </q-card-section>
    </q-card>
</template>
<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import ImageReproductor from "./ImageReproductor.vue";

defineProps({
    title: String,
    articles: {
        type: Array,
        default: [],
    },
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
</script>
