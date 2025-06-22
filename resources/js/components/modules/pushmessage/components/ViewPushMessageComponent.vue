<template>
    <q-btn-component
        icon="mdi-eye-outline"
        tooltips="vista previa"
        @click="showPreview"
    />

    <q-dialog
        v-model="dialogImage"
        persistent
        @show="onShowMedia"
        @hide="onHideMedia"
    >
        <q-card>
            <q-card-section style="width: 400px">
                <q-responsive :ratio="1">
                    <q-img :src="urlImage" :ratio="16 / 9" fit="fill" />
                </q-responsive>
                <q-btn
                    label="cerrar"
                    no-caps
                    color="primary"
                    outline
                    class="full-width q-mt-sm"
                    @click="dialogImage = false"
                />
            </q-card-section>
        </q-card>
    </q-dialog>
    <q-dialog
        v-model="dialogVideo"
        persistent
        @show="onShowMedia"
        @hide="onHideMedia"
    >
        <q-card>
            <q-card-section style="width: 400px">
                <q-responsive :ratio="1">
                    <q-video :src="urlVideo" v-if="blobVideo" />
                    <video-player
                        :src="urlVideo"
                        controls
                        aspectRatio="16:9"
                        :volume="0.6"
                        v-else
                    />
                </q-responsive>
                <q-btn
                    label="cerrar"
                    no-caps
                    color="primary"
                    outline
                    class="full-width q-mt-sm"
                    @click="dialogVideo = false"
                />
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import QBtnComponent from "../../../base/QBtnComponent.vue";
import { onMounted, ref } from "vue";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import { usePage } from "@inertiajs/vue3";
import { Dark, Notify, date } from "quasar";

defineOptions({
    name: "ViewPushMessageComponent",
});

const props = defineProps({
    data: Object,
});

const dialogImage = ref(false);
const dialogVideo = ref(false);
const urlImage = ref(null);
const urlVideo = ref(null);
let showing = false;
const blobVideo = ref(false);
const page = usePage();

const getLogo = async (campaign) => {
    let result = `${page.props.public_path}images/logo/1.png`;
    if (campaign !== null) {
        formBody.value?.loadingPreview(true);
        await axios
            .get(`/admin/campaigns/logo/${campaign}`)
            .then((response) => {
                result = `${page.props.public_path}${response.data.logo}`;
            })
            .catch(() => {})
            .finally(() => {
                formBody.value?.loadingPreview(false);
            });
    }
    return result;
};

const showPreview = async (timeout = 0) => {
    let {
        campaign_id,
        title,
        message,
        url,
        logo,
        image,
        video,
        action_button_title,
        action_button_url,
    } = props.data;
    if (title === null || title.trim() === "") {
        error("debe especificar el titulo");
    } else if (message === null || message.trim() === "") {
        error("debe especificar el mensaje");
    } else {
        if (logo === null) {
            logo = await getLogo(campaign_id);
        } else {
            logo =
                typeof logo === "string"
                    ? `${page.props.public_path}${logo}`
                    : URL.createObjectURL(logo);
        }
        let imgView = "";
        if (image !== null) {
            image =
                typeof image === "string"
                    ? `${page.props.public_path}storage/${image}`
                    : URL.createObjectURL(image);
            imgView = `<q-item-section><img src='${image}' width="120px" style="float: left;" class="q-mr-md"/></q-item-section>`;
        }
        let title_view = "";
        if (action_button_title) {
            title_view = `<q-item-label><a href="${action_button_url}" target="_blank" class="q-btn q-pa-sm q-mb-md q-btn-item q-btn--rectangle bg-black q-btn--no-uppercase text-white cursor-pointer" style="text-decoration:none;min-width: 120px;">${action_button_title}</a></q-item-label>`;
        }
        const notification = await Notify.create({
            message: `<q-item>${imgView}<q-item-section><q-item-label class='text-h6 q-mb-none'>${title}</q-item-label> <q-item-label>${message}<q-item-label>${title_view}</q-item-section></q-item><div class="row"><div class="col self-center" style="opacity: 0.7">${date.formatDate(
                new Date(),
                "MMMM DD, YYYY"
            )}</div><div class="col text-center"><img src='${logo}' width="80px"/></div><div class="col self-center text-right" style="font-size: 24px;">${
                video
                    ? '<button class="q-btn q-py-sm q-mb-md q-btn-item q-btn--rectangle bg-black q-btn--no-uppercase text-white cursor-pointer" id="video-btn">ver video</button>'
                    : ""
            }<button class="q-btn q-py-sm q-ml-sm q-mb-md q-btn-item q-btn--rectangle bg-black text-white cursor-pointer" id="notification-close">X</button></div></div>`,
            position: "top-left",
            html: true,
            color: "white",
            textColor: "black",
            iconSize: "100px",
            classes: "hidde-on-show-dialog",
            timeout: timeout,
            badgeStyle: {
                display: timeout === 1 ? "none" : "inherit",
            },
            onDismiss: () => {
                showing = false;
                dialogVideo.value = false;
                dialogImage.value = false;
            },
        });
        showing = true;

        let closeBtn = document.getElementById("notification-close");
        closeBtn.addEventListener("click", (ev) => {
            notification();
        });

        let videoBtn = document.getElementById("video-btn");
        if (videoBtn) {
            videoBtn.addEventListener("click", (ev) => {
                if (typeof video === "string") {
                    urlVideo.value = `${page.props.public_path}storage/${video}`;
                    blobVideo.value = true;
                } else {
                    urlVideo.value = URL.createObjectURL(video);
                    blobVideo.value = true;
                }
                dialogVideo.value = true;
            });
        }
    }
};

const onShowMedia = () => {
    document
        .getElementsByClassName("hidde-on-show-dialog")[0]
        .classList.add("hidden");
};
const onHideMedia = () => {
    document
        .getElementsByClassName("hidde-on-show-dialog")[0]
        .classList.remove("hidden");
};
</script>
