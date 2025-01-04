<template>
    <Layout>
        <q-page padding>
            <center>
                <q-card
                    flat
                    :style="{
                        'max-width':
                            screen.lg || screen.md
                                ? `${screen.width / 3}px`
                                : '',
                    }"
                >
                    <q-card-section>
                        <video-player
                            :src="`${$page.props.public_path}storage/${file.path}`"
                            :poster="
                                file.poster
                                    ? `${$page.props.public_path}storage/${file.poster}`
                                    : null
                            "
                            controls
                            :volume="0.6"
                            aspectRatio="1:1"
                            v-if="
                                file.type.startsWith('video/') ||
                                file.type.startsWith('audio/')
                            "
                        />
                        <q-item
                            tag="a"
                            clickable
                            dense
                            :href="`${$page.props.public_path}storage/${file.path}`"
                            class="glightbox"
                            :style="{
                                border: '1px solid #70707057',
                                padding: '0px',
                                'border-style': 'dotted',
                            }"
                            v-else-if="file.type.startsWith('image/')"
                        >
                            <q-img
                                fit="fill"
                                :ratio="1"
                                :src="`${$page.props.public_path}storage/${file.path}`"
                            />
                        </q-item>
                        <q-item
                            clickable
                            target="_blank"
                            :href="`${$page.props.public_path}storage/${file.path}`"
                            style="
                                border: 1px solid #70707057;
                                padding: 0px;
                                border-style: dotted;
                            "
                            v-else
                            ><q-img
                                fit="fill"
                                :ratio="1"
                                :src="`${$page.props.public_path}images/others/file.png`"
                        /></q-item>
                    </q-card-section>
                </q-card>
            </center>
        </q-page>
    </Layout>
</template>

<script setup>
import { computed, onMounted } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import { useQuasar } from "quasar";

defineOptions({
    name: "SharedFile",
});

const file = computed(() => {
    return usePage().props.file;
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

onMounted(() => {
    var lightbox = GLightbox();
});
</script>
