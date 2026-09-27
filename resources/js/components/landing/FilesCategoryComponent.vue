<template>
    <div class="row" v-if="category.files.length > 0">
        <div class="col-xl-12 col-lg-12 col-sm-12 col-sm-12 text-center">
            <q-btn
                label="quiero recibir mi newsletter!"
                rounded
                color="black"
                no-caps
                class="q-mb-xl"
                href="/#suscribe"
                v-if="
                    category?.name?.toLowerCase() == 'newsletter' ||
                    category?.name?.toLowerCase() == 'newsletters'
                "
            />
        </div>

        <q-intersection
            v-for="(file, index) in visibleFiles"
            :key="`file-${index}`"
            :class="cls"
            once
            transition="scale"
        >
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
                    v-if="['video', 'audio'].includes(file.file_type)"
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
                    v-else-if="file.file_type === 'image'"
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
                        :src="`${$page.props.public_path}${
                            file.poster
                                ? `storage/${file.poster}`
                                : 'images/icon/black-file.png'
                        }`"
                /></q-item>
            </template>
            <template v-else>
                <q-card
                    class="my-card q-ma-sm rounded"
                    v-if="file.file_type !== 'text'"
                >
                    <q-card-section
                        class="q-pa-none"
                        style="border-bottom: 1px solid #70707057; padding: 2px"
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
                            class="rounded-top"
                            :class="file.poster ? 'bg-white' : ''"
                            @play="onPlayVideo"
                            v-if="['video', 'audio'].includes(file.file_type)"
                        />
                        <q-img
                            :src="`${$page.props.public_path}storage/${file.path}`"
                            fit="fill"
                            class="rounded-top cursor-pointer"
                            img-class="glightbox"
                            :ratio="16 / 9"
                            v-else-if="file.file_type === 'image'"
                        />
                        <q-img
                            :src="`${$page.props.public_path}${
                                file.poster
                                    ? `storage/${file.poster}`
                                    : 'images/icon/black-file.png'
                            }`"
                            fit="fill"
                            class="rounded-top cursor-pointer"
                            :ratio="16 / 9"
                            @click="
                                open(
                                    file.file_type === 'link'
                                        ? (file.link ?? file.name)
                                        : `${$page.props.public_path}storage/${file.path}`,
                                )
                            "
                            v-else
                        />
                    </q-card-section>
                    <q-card-section class="text-center">
                        <q-item-label lines="3">
                            {{
                                file.file_type === "link"
                                    ? file.name
                                    : file.name.indexOf(".") >= 0
                                      ? file.name.substring(
                                            0,
                                            file.name.lastIndexOf("."),
                                        )
                                      : file.name
                            }}
                        </q-item-label>
                        <q-item-label
                            class="q-pt-sm cursor-pointer text-primary"
                        >
                            <a
                                class="text-uppercase text-primary"
                                :href="
                                    file.file_type === 'link'
                                        ? (file.link ?? file.name)
                                        : `${$page.props.public_path}storage/${file.path}`
                                "
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
                        <span v-html="file.message"></span>
                    </q-card-section>
                    <q-card-section class="text-center">
                        <q-item-label v-if="file.anonimous">
                            <i>publicado como anonimo</i>
                        </q-item-label>
                        <q-item-label v-else-if="file.name_to_show">
                            {{ file.name_to_show }}
                        </q-item-label>
                        <q-item-label v-else>
                            {{ file.user?.full_name }}
                        </q-item-label>
                    </q-card-section>
                </q-card>
            </template>
        </q-intersection>

        <div
            v-if="hasMore"
            ref="sentinel"
            class="col-12 flex flex-center q-pa-lg"
        >
            <q-spinner color="primary" size="2em" />
        </div>
    </div>

    <div class="row text-center q-mb-md" v-if="category.files.length === 0">
        <h3>
            lo sentimos, aun no se han hecho publicaciones en esta categoria
        </h3>
    </div>
</template>

<script setup>
import {
    ref,
    onMounted,
    onBeforeUnmount,
    computed,
    nextTick,
    watch,
} from "vue";
import { openURL } from "quasar";
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

const defaultsCategories = ref(["post", "posts", "newsletter", "newsletters"]);

const PAGE_SIZE = 12;

const visibleCount = ref(PAGE_SIZE);

const sentinel = ref(null);

let observer = null;

const visibleFiles = computed(() => {
    if (!props.category?.files) return [];
    return props.category.files.slice(0, visibleCount.value);
});

const hasMore = computed(() => {
    return (
        props.category?.files &&
        visibleCount.value < props.category.files.length
    );
});

const loadMore = () => {
    if (!hasMore.value) return;
    const remaining = props.category.files.length - visibleCount.value;
    visibleCount.value += Math.min(PAGE_SIZE, remaining);
};

const setupObserver = () => {
    if (observer) observer.disconnect();
    if (!sentinel.value) return;

    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) {
                loadMore();
            }
        },
        {
            rootMargin: "300px 0px",
            threshold: 0,
        },
    );

    observer.observe(sentinel.value);
};

let lightbox = null;

onMounted(() => {
    lightbox = GLightbox({
        selector: ".glightbox",
        touchNavigation: true,
        loop: false,
    });

    nextTick(() => {
        setupObserver();
    });
});

onBeforeUnmount(() => {
    if (observer) {
        observer.disconnect();
        observer = null;
    }
});

watch(visibleCount, () => {
    nextTick(() => {
        if (lightbox) {
            lightbox.reload();
        }
    });
});

watch(sentinel, (el) => {
    if (el) {
        nextTick(() => setupObserver());
    }
});

watch(
    () => props.category,
    () => {
        visibleCount.value = PAGE_SIZE;
    },
);

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

const open = (url) => {
    openURL(url, undefined);
};

const onPlayVideo = (evt) => {
    if (evt.target.classList.contains("bg-white")) {
        evt.target.classList.remove("bg-white");
    }
};
</script>
