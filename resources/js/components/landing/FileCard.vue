<template>
    <template v-if="defaultsCategories.includes(category?.name?.toLowerCase())">
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
        >
            <q-img
                fit="fill"
                :ratio="1"
                :src="`${$page.props.public_path}${
                    file.poster
                        ? `storage/${file.poster}`
                        : 'images/icon/black-file.png'
                }`"
            />
        </q-item>
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
                <q-item-label class="q-pt-sm cursor-pointer text-primary">
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
</template>

<script setup>
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import { openURL } from "quasar";

defineOptions({ name: "FileCard" });

defineProps({
    file: { type: Object, required: true },
    category: { type: Object, default: null },
});

const defaultsCategories = ["post", "posts", "newsletter", "newsletters"];

const open = (url) => {
    openURL(url, undefined);
};

const onPlayVideo = (evt) => {
    if (evt.target.classList.contains("bg-white")) {
        evt.target.classList.remove("bg-white");
    }
};
</script>
