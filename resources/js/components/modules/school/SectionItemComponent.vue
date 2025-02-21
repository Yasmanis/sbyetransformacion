<template>
    <q-card :class="class">
        <q-card-section class="q-pa-sm">
            <q-list dense>
                <q-item style="padding: 2px 8px">
                    <q-item-section>
                        <q-item-label lines="1" class="text-bold">
                            {{ section.name }}
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar>
                        <btn-down-up-component
                            :up="!expand"
                            @click="expand = !expand"
                        />
                    </q-item-section>
                </q-item>
                <q-item style="padding: 2px 8px">
                    <q-item-section avatar style="padding-right: 5px">
                        <q-icon
                            name="mdi-check"
                            v-if="section.topics.length === courses_completed"
                        ></q-icon>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>
                            {{ courses_completed }}/{{ section.topics.length }}
                            <span
                                v-if="
                                    courses_completed == section.topics.length
                                "
                                >completo</span
                            >
                        </q-item-label>
                    </q-item-section>
                </q-item>
                <q-item v-if="expand">
                    <q-item-section>
                        <q-list dense>
                            <q-item
                                v-for="(topic, topicIndex) in section.topics"
                                :key="topicIndex"
                            >
                                <q-item-section
                                    avatar
                                    top
                                    style="padding-right: 5px"
                                >
                                    <q-icon
                                        name="mdi-checkbox-blank-circle-outline"
                                        v-if="topic.percent === 0"
                                    ></q-icon>
                                    <q-icon
                                        name="mdi-check-circle-outline"
                                        v-else-if="topic.percent === 100"
                                    ></q-icon>
                                    <q-icon v-else>
                                        <q-knob
                                            v-model="topic.percent"
                                            size="18px"
                                            :thickness="1"
                                            :color="
                                                Dark.isActive
                                                    ? 'white'
                                                    : 'black'
                                            "
                                            track-color="transparent"
                                        ></q-knob>
                                    </q-icon>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label
                                        style="cursor: pointer"
                                        @click="changeTopic(topic)"
                                        >{{ topic.name }}</q-item-label
                                    >
                                    <q-item-label
                                        v-if="topic.duration_string !== null"
                                    >
                                        <q-icon
                                            name="mdi-video"
                                            size="sm"
                                        ></q-icon>
                                        ({{ topic.duration_string }})
                                        <q-icon
                                            name="mdi-attachment fa-rotate-90"
                                            size="sm"
                                            v-if="topic.has_resources"
                                        ></q-icon>
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section avatar top>
                                    <q-btn-component
                                        tooltips="pasar a pantalla principal"
                                        icon="mdi-play-circle-outline"
                                        @click="changeTopic(topic)"
                                    />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
    </q-card>

    <video-component
        :show="showVideo"
        :video="principalVideo"
        :topic="currentTopic"
        @close="showVideo = false"
    ></video-component>

    <confirm-component
        :show="showNoAccess"
        :header="false"
        :question="null"
        :cancel="true"
        icon-confirm="mdi-video-account"
        icon-confirm-size="18px"
        icon-confirm-tooltips="ir a testimonios"
        :message="`para ver el contenido de este tema debes <br> cumplir el requisito de haber dado un testimonio. pulsa <a class='text-bold cursor-pointer' href='/publicaciones/2#form-testimony'>aqui</a> para adjuntar tu testimonio o escribirlo`"
        @hide="showNoAccess = false"
        @ok="router.get('/publicaciones/2#form-testimony')"
    />

    <confirm-component
        width="435px"
        :show="showNoAccessByVolume"
        :header="false"
        :question="null"
        icon-confirm="mdi-checkbox-marked-circle-outline"
        icon-confirm-size="18px"
        icon-confirm-tooltips="ir a testimonios"
        :message="`para ver el contenido de este tomo debes <br> adquirido <a class='text-bold cursor-pointer' href='https://www.amazon.es/dp/B0DJG45MMK?binding=paperback&ref=dbs_dp_sirpi'>aqui</a> y enviarnos a traves del <a class='text-bold cursor-pointer' href='/contactame'>formulario <br> de contacto</a> los datos que se te requieren para darte de alta en el area privada`"
        @hide="showNoAccessByVolume = false"
        @ok="showNoAccessByVolume = false"
    />
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDownUpComponent from "../../btn/BtnDownUpComponent.vue";
import VideoComponent from "./VideoComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import { router } from "@inertiajs/vue3";
import { Dark } from "quasar";

defineOptions({
    name: "SectionItemComponent",
});

const props = defineProps({
    section: Object,
    sectionIndex: Number,
    class: String,
    expand: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["change-topic"]);

const expand = ref(props.expand);
const courses_completed = ref(0);
const showVideo = ref(false);
const principalVideo = ref(null);
const showNoAccess = ref(false);
const showNoAccessByVolume = ref(false);
const currentTopic = ref(null);

onMounted(() => {
    updateViewSection();
});

watch(
    () => props.section,
    (n, o) => {
        updateViewSection();
    }
);

const updateViewSection = () => {
    const topics = props.section.topics;
    let ltopics = topics.length;
    let view = true;
    courses_completed.value = 0;
    for (let i = 0; i < ltopics; i++) {
        view = true;
        const resources = topics[i].resources;
        for (let j = 0; j < resources.length; j++) {
            if (resources[j].video && !resources[j].view) {
                view = false;
                break;
            }
        }
        if (view) {
            courses_completed.value++;
        }
    }
};

const changeTopic = (topic) => {
    emits("change-topic", {
        topic: topic,
        section: props.section,
        sectionIndex: props.sectionIndex,
    });
    if (topic.has_access && topic.has_access_by_volume) {
        principalVideo.value = topic.resources.find((r) => r.principal);
        currentTopic.value = topic;
        if (principalVideo.value) {
            showVideo.value = true;
        }
    } else if (!topic.has_access_by_volume) {
        showNoAccessByVolume.value = true;
    } else {
        showNoAccess.value = true;
    }
};
</script>
<style scope>
.q-knob--editable:before {
    border: 1px solid #000;
}
</style>
