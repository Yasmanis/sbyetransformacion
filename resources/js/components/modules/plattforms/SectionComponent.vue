<template>
    <q-card>
        <q-card-section>
            <div class="col">
                <div class="row items-center">
                    <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                        <image-reproductor
                            :src="`${page.props.public_path}storage/${topic ? (topic.file_type === 'image' ? topic.path : topic.poster) : null}`"
                            :reproductor="topic?.file_type === 'video'"
                            @play="emits('play', topic)"
                        />
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <q-item dense>
                            <q-item-section
                                class="text-center text-h6 q-mb-none"
                            >
                                <q-item-label>
                                    {{ topic?.name }}
                                </q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-list dense>
                            <q-item
                                v-for="(r, indexResource) in attachments"
                                :key="`resource_${indexResource}`"
                                style="padding: 0"
                            >
                                <q-item-section
                                    avatar
                                    style="padding-right: 5px"
                                >
                                    <q-icon
                                        :name="
                                            r.principal
                                                ? 'mdi-video'
                                                : 'mdi-file'
                                        "
                                        size="18px"
                                    ></q-icon>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label lines="1">
                                        <span
                                            @click="emits('play', r)"
                                            v-if="r.file_type === 'video'"
                                            style="cursor: pointer"
                                            >&nbsp;{{ r.name }}</span
                                        >
                                        <a
                                            :href="`${page.props.public_path}storage/${r.path}`"
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
                                        @click="emits('play', r)"
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
                <div
                    class="row q-pa-sm custom-font-size"
                    v-if="topic?.description"
                >
                    <span
                        v-html="topic?.description"
                        style="margin-bottom: -30px"
                    ></span>
                </div>
            </div>
        </q-card-section>
    </q-card>

    <chat-component
        :segment="segment"
        :topic="props.topic"
        topicable-type="App\Models\File"
        :section="section"
        :index="indexTopic"
        :has_edit="has_edit"
        :show-chat="showChat"
        @change-topic="(i) => emits('change-topic', i)"
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
import { onMounted, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import ImageReproductor from "../../others/ImageReproductor.vue";
import ChatComponent from "../school/chat/ChatComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";
import axios from "axios";

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

const emits = defineEmits(["change-topic", "play"]);

const showNoAccess = ref(false);
const showNoAccessByVolume = ref(false);
const page = usePage();

const attachments = ref([]);

watch(
    () => props.topic,
    (n) => {
        loadAttachments();
    },
    {
        deep: true,
    },
);

onMounted(async () => {
    await loadAttachments();
});

const loadAttachments = async () => {
    if (props.topic) {
        await axios
            .post(`/admin/files/childs/${props.topic.id}`)
            .then((res) => {
                attachments.value = res.data || [];
            });
    } else {
        attachments.value = [];
    }
};
</script>
