<template>
    <div class="col">
        <div class="row items-center">
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <q-img
                    :src="`${page.props.public_path}storage/${topic?.coverImage}`"
                    style="
                        height: 180px;
                        width: 180px;
                        border: 1px solid lightgray;
                    "
                >
                    <div class="absolute-full text-subtitle2 flex flex-center">
                        <q-btn-component
                            :tooltips="!principalVideo ? '' : 'reproducir'"
                            icon="fab fa-youtube"
                            @click="startVideo(principalVideo)"
                            :disable="!principalVideo"
                            size="md"
                        />
                    </div>
                    <template v-slot:error>
                        <div
                            class="absolute-full flex flex-center bg-negative text-white"
                        >
                            error al tratar de obtener la imagen
                        </div>
                    </template>
                </q-img>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <p class="text-center text-uppercase section-number">
                    <span>
                        seccion
                        {{ totalSections > 0 ? index + 1 : 0 }}/{{
                            totalSections
                        }}
                    </span>
                </p>

                <p
                    class="text-center section-title"
                    style="margin-bottom: 15px !important"
                >
                    {{ topic?.name }}
                </p>

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
                                    class="text-black"
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
                                icon="mdi-play"
                                size="xs"
                                @click="startVideo(r)"
                            />
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-left: 5px"
                        >
                            <q-btn-component
                                tooltips="descargar"
                                :href="`${page.props.public_path}storage/${r.path}`"
                                target="_blank"
                                icon="mdi-cloud-download-outline"
                                size="xs"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
    </div>

    <q-dialog
        v-model="showVideo"
        persistent
        @before-hide="onHideVideo"
        v-if="currentVideo"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-video"
                :title="currentVideo.name"
                closable
            />
            <q-card-section class="col q-pt-none">
                <div class="col-sm-12 col-md-12 text-center">
                    <video
                        width="320"
                        height="240"
                        :src="`${page.props.public_path}storage/${currentVideo.path}`"
                        controls
                        @timeupdate="onTimeUpdate"
                        @loadedmetadata="onLoadedMetadata"
                        @play="onPlay"
                    ></video>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    label="cerrar"
                    outline
                    square
                    size="md"
                    padding="5px"
                    color="red"
                    no_caps
                    icon="mdi-close-circle-outline"
                    v-close-popup
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

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
    totalSections: {
        type: Number,
        default: 0,
    },
});

const emits = defineEmits(["video-completed", "realod-sections"]);

const currentVideo = ref(null);
const showVideo = ref(false);
const currentTime = ref(0);
const totalTime = ref(0);

const page = usePage();

const principalVideo = computed(() => {
    return props.topic.resources.find((r) => r.principal);
});

const onHideVideo = async () => {
    await axios
        .post(
            `${props.url}/${props.base}/update-video-percentaje-to-user/${currentVideo.value.id}`,
            {
                last_time: currentTime.value,
                total_time: totalTime.value,
            }
        )
        .then((response) => {
            const data = response.data;
            currentVideo.value.percent = data.video.percent;
            currentTopic.value.percent = data.video.percent;
            emit("realod-sections", data.course_percentage);
        })
        .catch((error) => {});
};

const onTimeUpdate = (ev) => {
    currentTime.value = ev.target.currentTime;
};

const onLoadedMetadata = (ev) => {
    totalTime.value = ev.target.duration;
    ev.target.currentTime = currentVideo.value.current_time;
};

const startVideo = (video) => {
    currentVideo.value = video;
    showVideo.value = true;
};
</script>
