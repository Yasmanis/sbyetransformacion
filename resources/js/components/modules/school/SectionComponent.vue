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
                            :disable="!principalVideo || !topic.has_access"
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
                                :disable="
                                    totalSections === index + 1 ||
                                    (skip.includes(segment) &&
                                        !allTopicsCompleted())
                                "
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
                            <btn-left-right-component
                                :disable="getIndexFromCurrentTopic() - 1 < 0"
                                @click="
                                    emits(
                                        'change-topic',
                                        getIndexFromCurrentTopic() - 1
                                    )
                                "
                            />
                            {{ topic?.name }}
                            <btn-left-right-component
                                :leftDirection="false"
                                :disable="
                                    getIndexFromCurrentTopic() + 1 ===
                                        section?.topics?.length ||
                                    (skip.includes(segment) &&
                                        !allTopicsCompleted())
                                "
                                @click="changeTopic"
                            />
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
                                    :href="
                                        topic.has_access
                                            ? `${page.props.public_path}storage/${r.path}`
                                            : null
                                    "
                                    target="_blank"
                                    class="cursor-pointer"
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
                                :disable="!topic.has_access"
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
                                :disable="!topic.has_access"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
        <div class="row q-pa-sm" v-if="topic?.description">
            <span
                v-html="topic?.description"
                style="margin-bottom: -30px"
            ></span>
        </div>
    </div>
    <chat-component
        :segment="segment"
        :topic="props.topic"
        :section="section"
        :index="indexTopic"
        :has_edit="has_edit"
        :show-chat="showChat"
        @change-topic="(i) => emits('change-topic', i)"
    />

    <video-component
        :show="showVideo"
        :video="currentVideo"
        :topic="topic"
        @close="showVideo = false"
    />

    <confirm-component
        :show="showNoAccess"
        :header="false"
        :question="null"
        :cancel="true"
        icon-confirm="mdi-video-account"
        icon-confirm-size="18px"
        icon-confirm-tooltips="ir a testimonios"
        :message="`para ver el contenido de este tema debes <br> cumplir el requisito de haber dado un testimonio. pulsa <a class='text-bold cursor-pointer' href='/admin/testimony'>aqui</a> para adjuntar tu testimonio o escribirlo`"
        @hide="showNoAccess = false"
        @ok="router.get('/admin/testimony')"
    />

    <confirm-component
        width="435px"
        :show="showNoAccessByVolume"
        :header="false"
        :question="null"
        icon-confirm="mdi-checkbox-marked-circle-outline"
        icon-confirm-size="18px"
        icon-confirm-tooltips="ir a testimonios"
        :message="`para ver el contenido de este tomo debes <br> adquirido <a class='text-bold cursor-pointer text-black' href='https://www.amazon.es/dp/B0DJG45MMK?binding=paperback&ref=dbs_dp_sirpi'>aqui</a> y enviarnos a traves del <a class='text-bold cursor-pointer text-black' href='/contactame'>formulario <br> de contacto</a> los datos que se te requieren para darte de alta en el area privada`"
        @hide="showNoAccessByVolume = false"
        @ok="showNoAccessByVolume = false"
    />
</template>

<script setup>
import { computed, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../btn/BtnLeftRightComponent.vue";
import ChatComponent from "./chat/ChatComponent.vue";
import VideoComponent from "./VideoComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

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
    showChat: String,
    segment: String,
    skip: {
        type: Array,
        default: [],
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["change-section", "change-topic"]);

const currentVideo = ref(null);
const showVideo = ref(false);
const showNoAccess = ref(false);
const showNoAccessByVolume = ref(false);
const page = usePage();

const principalVideo = computed(() => {
    return props.topic.resources.find((r) => r.principal);
});

const startVideo = (video) => {
    if (props.topic.has_access) {
        currentVideo.value = video;
        showVideo.value = true;
    } else {
        //showNoAccess.value = true;
    }
};

const allTopicsCompleted = () => {
    if (page.props.auth.user.sa) {
        return true;
    }
    const topics = props?.section?.topics ?? [];
    for (let i = 0; i < topics.length; i++) {
        const temp = topics[i];
        if (temp.percent < 95 && temp.has_principal_video && !temp.skip) {
            return false;
        }
    }
    return true;
};

const getIndexFromCurrentTopic = () => {
    if (!props.section || !props.topic) {
        return -1;
    }
    return props.section.topics.findIndex((t) => t.id === props.topic.id);
};

const othersCompleted = (first, last) => {
    if (usePage().props.auth.user.sa) {
        return true;
    }
    const topics = props.section.tooltips;
    const firstIndex = topics.findIndex((t) => t.id === first.id);
    const lastIndex = topics.findIndex((t) => t.id === last.id);
    if (firstIndex > lastIndex) {
        return true;
    }
    for (let i = firstIndex; i < lastIndex; i++) {
        const temp = topics[i];
        if (temp.percent < 95 && temp.has_principal_video && !temp.skip) {
            return false;
        }
    }
    return true;
};

const changeTopic = () => {
    const t = props.topic;
    const index = getIndexFromCurrentTopic() + 1;
    const topic = props.section.topics[index];
    if (topic.has_access && topic.has_access_by_volume) {
        if (props.skip.includes(props.segment) && !othersCompleted(t, topic)) {
            info("no se puede pasar a este tema sin completar los anteriores");
        } else {
            emits("change-topic", index);
        }
    } else if (!topic.has_access_by_volume) {
        showNoAccessByVolume.value = true;
    } else {
        showNoAccess.value = true;
    }
};
</script>
