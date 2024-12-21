<template>
    <div class="row" v-if="category.files.length > 0">
        <template
            v-for="(file, indexFile) in category.files"
            :key="`file-${indexFile}`"
        >
            <div :class="cls">
                <template v-if="defaultsCategories.includes(category.name)">
                    <video-player
                        :src="`${$page.props.public_path}storage/${file.path}`"
                        :poster="
                            file.poster
                                ? `${$page.props.public_path}storage/${file.poster}`
                                : null
                        "
                        controls
                        responsive
                        :volume="0.6"
                        aspectRatio="16:9"
                        class="full-width full-height"
                        :style="{
                            border: '1px solid #70707057',
                            padding: '0px',
                            'border-style': 'dotted',
                            background: '#fff !important',
                            height: $q.screen.xs
                                ? `${($q.screen.width - 6) / 1.77}px !important`
                                : null,
                        }"
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
                        style="
                            border: 1px solid #70707057;
                            padding: 0px;
                            border-style: dotted;
                        "
                        v-else-if="file.type.startsWith('image/')"
                    >
                        <q-img
                            fit="fill"
                            :ratio="16 / 9"
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
                            :ratio="16 / 9"
                            :src="`${$page.props.public_path}images/others/file.png`"
                    /></q-item>
                </template>
                <template v-else>
                    <q-card class="my-card q-ma-sm rounded">
                        <q-card-section
                            class="q-pa-sm q-pa-none bg-black"
                            style="background-color: #000 !important"
                        >
                            <video-player
                                :src="`${$page.props.public_path}storage/${file.path}`"
                                :poster="
                                    file.poster
                                        ? `${$page.props.public_path}storage/${file.poster}`
                                        : null
                                "
                                controls
                                responsive
                                :volume="0.6"
                                class="full-width header-card"
                                v-if="
                                    file.type.startsWith('video/') ||
                                    file.type.startsWith('audio/')
                                "
                            />
                            <a
                                :href="`${$page.props.public_path}storage/${file.path}`"
                                target="_blank"
                                v-else
                            >
                                <div
                                    class="rounded-top full-width header-card"
                                ></div>
                                <div class="column items-center">
                                    <i
                                        class="fa fa-file fa-4x text-white"
                                        style="margin-top: -120px"
                                    ></i>
                                </div>
                            </a>
                        </q-card-section>
                        <q-card-section class="text-center">
                            <q-item-label lines="3">
                                {{
                                    file.name.indexOf(".") >= 0
                                        ? file.name.substring(
                                              0,
                                              file.name.lastIndexOf(".")
                                          )
                                        : file.name
                                }}
                            </q-item-label>
                            <q-item-label
                                class="q-pt-sm cursor-pointer text-primary"
                            >
                                <a
                                    class="text-uppercase text-primary"
                                    :href="`${$page.props.public_path}storage/${file.path}`"
                                    target="_blank"
                                    ><small>ver</small></a
                                >
                            </q-item-label>
                        </q-card-section>
                    </q-card>
                </template>
            </div>
        </template>
    </div>
    <div class="row" v-else-if="testimonies.length > 0">
        <template v-for="(t, index) in testimonies" :key="`testimony-${index}`">
            <div :class="cls">
                <q-card
                    class="my-card q-ma-sm rounded"
                    v-if="t.type === 'video'"
                >
                    <q-card-section
                        class="q-pa-sm q-pa-none bg-black"
                        style="background-color: #000 !important"
                    >
                        <video-player
                            :src="`${$page.props.public_path}storage/${t.message}`"
                            controls
                            responsive
                            :volume="0.6"
                            class="full-width header-card"
                        />
                    </q-card-section>
                    <q-card-section class="text-center">
                        <q-item-label>
                            {{ t.user.full_name }}
                        </q-item-label>
                        <q-item-label
                            class="q-pt-sm cursor-pointer text-primary"
                        >
                            <a
                                class="text-uppercase text-primary"
                                :href="`${$page.props.public_path}storage/${t.message}`"
                                target="_blank"
                                ><small>ver</small></a
                            >
                        </q-item-label>
                    </q-card-section>
                </q-card>
                <q-card flat bordered class="my-card q-ma-sm" style="border: 1px solid rgb(64, 116, 146)" v-else>
                    <q-card-section class="q-pa-sm q-pa-none text-center">
                        <q-img
                            :src="`${$page.props.public_path}images/icon/heart.png`"
                            fit="fill"
                            width="50px"
                        />
                    </q-card-section>
                    <q-card-section class="q-pa-sm q-pa-none text-center">
                        {{ t.message }}
                    </q-card-section>
                    <q-card-section class="text-center">
                        <q-item-label>
                            {{ t.user.full_name }}
                        </q-item-label>
                    </q-card-section>
                </q-card>
            </div>
        </template>
    </div>
    <div class="row text-center q-mb-md" v-else>
        <h3>
            lo sentimos, aun no se han hecho publicaciones en esta categoria
        </h3>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useQuasar } from "quasar";
import { usePage } from "@inertiajs/vue3";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";

defineOptions({
    name: "FilesCategoryComponent",
});

const props = defineProps({
    category: Object,
});

const $q = useQuasar();

const defaultsCategories = ref(["post", "posts", "newsletter", "newsletters"]);

onMounted(() => {
    var lightbox = GLightbox();
});

const cls = computed(() => {
    let category = props.category;
    if (category) {
        category = category.name.toLowerCase();
        if (category === "post" || category === "posts") {
            return "col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pa-sm";
        } else if (category === "newsletter" || category === "newsletters") {
            return "col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pa-sm text-center";
        } else {
            return "col-lg-6 col-md-6 col-sm-6 col-xs-12";
        }
    }
    return null;
});

const testimonies = computed(() => {
    return usePage().props.testimonies;
});
</script>
