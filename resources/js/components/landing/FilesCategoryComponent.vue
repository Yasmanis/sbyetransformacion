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
                        style="
                            border: 1px solid #70707057;
                            padding: 0px;
                            border-style: dotted;
                        "
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
                </template>
                <template
                    v-else-if="category.name.toLowerCase() !== 'testimonios'"
                >
                    <q-card class="my-card q-ma-sm rounded">
                        <q-card-section
                            class="q-pa-sm q-pa-none bg-black rounded-top"
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
                                aspectRatio="16:9"
                                :volume="0.6"
                                v-if="
                                    file.type.startsWith('video/') ||
                                    file.type.startsWith('audio/')
                                "
                            />
                            <q-img
                                :src="`${$page.props.public_path}images/icon/white-file.png`"
                                fit="fill"
                                :ratio="16 / 9"
                                v-else
                            />
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
    <div
        class="row"
        v-if="
            category.name.toLowerCase() === 'testimonios' ||
            testimonies.length > 0
        "
    >
        <template v-if="category.name.toLowerCase() === 'testimonios'">
            <template
                v-for="(file, indexTestimonyFile) in category.files"
                :key="`file-testimony-${indexTestimonyFile}`"
            >
                <div :class="cls" v-if="file.type.startsWith('video/')">
                    <q-card class="my-card q-ma-sm rounded">
                        <q-card-section
                            class="q-pa-sm q-pa-none bg-black rounded-top"
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
                                aspectRatio="16:9"
                                :volume="0.6"
                            />
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
                </div>
            </template>
        </template>
        <template v-for="(t, index) in testimonies" :key="`testimony-${index}`">
            <div :class="cls">
                <q-card
                    class="my-card q-ma-sm rounded"
                    v-if="t.type === 'video'"
                >
                    <q-card-section
                        class="q-pa-sm q-pa-none bg-black rounded-top"
                        style="background-color: #000 !important"
                    >
                        <video-player
                            :src="`${$page.props.public_path}storage/${t.message}`"
                            controls
                            aspectRatio="16:9"
                            :volume="0.6"
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
                <q-card
                    bordered
                    class="my-card q-ma-sm rounded"
                    style="border: 1px solid rgb(64, 116, 146)"
                    v-else
                >
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
    <div
        class="row text-center q-mb-md"
        v-if="category.files.length === 0 && testimonies.length === 0"
    >
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
<style>
.rounded-top {
    border-top-left-radius: 20px !important;
    border-top-right-radius: 20px !important;
}

.vjs-big-play-button {
    top: 50% !important;
    left: 50% !important;
    width: 40px !important;
    height: 40px !important;
    border-radius: 20px !important;
    border: none !important;
    line-height: 1.4em !important;
    margin-top: -20px !important;
    margin-left: -20px !important;
}
.q-card.rounded .vjs-poster {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}
</style>
