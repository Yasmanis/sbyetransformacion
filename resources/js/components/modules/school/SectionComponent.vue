<template>
    <div class="col">
        <div class="row items-center">
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <q-img
                    :src="`${page.props.public_path}storage/${topic?.coverImage}`"
                    fit="fill"
                    style="
                        border: 1px solid lightgray;
                        max-width: 200px;
                        max-height: 200px;
                    "
                >
                    <div class="absolute-full text-subtitle2 flex flex-center">
                        <q-btn-component
                            :tooltips="!principalVideo ? '' : 'reproducir'"
                            icon="fab fa-youtube"
                            color="primary"
                            @click="startVideo(principalVideo)"
                            :disable="!principalVideo"
                            size="xl"
                        />
                    </div>
                    <template v-slot:error>
                        <div
                            class="absolute-full flex flex-center bg-negative text-black"
                        >
                            error al tratar de obtener la imagen
                        </div>
                    </template>
                </q-img>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <q-item dense>
                    <q-item-section
                        class="text-center text-uppercase section-number text-h6 q-mb-none"
                    >
                        <q-item-label>
                            <btn-left-right-component
                                :disable="index === 0"
                                @click="emits('change-section', index - 1)"
                            />
                            seccion {{ totalSections > 0 ? index + 1 : 0 }}/{{
                                totalSections
                            }}
                            <btn-left-right-component
                                :leftDirection="false"
                                :disable="totalSections === index + 1"
                                @click="emits('change-section', index + 1)"
                            />
                        </q-item-label>
                    </q-item-section>
                </q-item>

                <q-item dense>
                    <q-item-section
                        class="text-center section-title text-h6 q-mt-none"
                    >
                        <q-item-label>
                            {{ topic?.name }}
                        </q-item-label>
                    </q-item-section>
                </q-item>

                <q-list dense>
                    <q-item
                        v-for="(r, indexResource) in topic?.resources"
                        :key="`resource_${indexResource}`"
                        style="padding: 0"
                    >
                        <q-item-section avatar style="padding-right: 5px">
                            <q-icon
                                :name="r.principal ? 'mdi-video' : 'mdi-file'"
                                size="18px"
                            ></q-icon>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label lines="1">
                                <span
                                    @click="startVideo(r)"
                                    v-if="r.video"
                                    style="cursor: pointer"
                                    >&nbsp;{{ r.name }}</span
                                >
                                <a
                                    :href="`${page.props.public_path}storage/${r.path}`"
                                    target="_blank"
                                    :class="
                                        Dark.isActive
                                            ? 'text-white'
                                            : 'text-black'
                                    "
                                    style="text-decoration: none"
                                    v-else
                                    >{{ r.name }}</a
                                >
                                <q-tooltip
                                    class="text-body2"
                                    anchor="top middle"
                                    self="bottom middle"
                                    :offset="[5, 5]"
                                    >{{ r.name }}</q-tooltip
                                >
                            </q-item-label>
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-left: 0"
                            v-if="r.video"
                        >
                            <q-btn-component
                                tooltips="reproducir"
                                icon="mdi-play-circle-outline"
                                @click="startVideo(r)"
                            />
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-left: 5px"
                        >
                            <btn-download-component
                                :href="`${page.props.public_path}storage/${r.path}`"
                                size="12px"
                                target="_blank"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
    </div>
    <chat-component
        :topic="props.topic"
        :section="section"
        :index="indexTopic"
        @change-topic="(i) => emits('change-topic', i)"
    />

    <video-component
        :show="showVideo"
        :video="currentVideo"
        @close="showVideo = false"
    />
</template>

<script setup>
import { computed, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../btn/BtnLeftRightComponent.vue";
import ChatComponent from "./chat/ChatComponent.vue";
import VideoComponent from "./VideoComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { useQuasar, Dark } from "quasar";

defineOptions({
    name: "SectionComponent",
});

const props = defineProps({
    section: Object,
    topic: Object,
    index: {
        type: Number,
        default: 0,
    },
    indexTopic: {
        type: Number,
        default: 0,
    },
    totalSections: {
        type: Number,
        default: 0,
    },
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const emits = defineEmits(["change-section", "change-topic"]);

const currentVideo = ref(null);
const showVideo = ref(false);
const page = usePage();

const principalVideo = computed(() => {
    return props.topic.resources.find((r) => r.principal);
});

const startVideo = (video) => {
    currentVideo.value = video;
    showVideo.value = true;
};
</script>
