<template>
    <q-dialog v-model="showDialog" persistent @before-hide="onHide">
        <q-card>
            <dialog-header-component
                icon="mdi-video"
                :title="video.name"
                closable
            />
            <q-card-section class="col q-pt-none">
                <div class="col-sm-12 col-md-12 text-center">
                    <video
                        width="320"
                        height="240"
                        autoplay
                        :src="`${$page.props.public_path}storage/${video.path}`"
                        controls
                        @timeupdate="onTimeUpdate"
                        @loadedmetadata="onLoadedMetadata"
                        @play="onPlay"
                    ></video>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";

defineOptions({
    name: "VideoComponent",
});

const props = defineProps({
    video: Object,
    show: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);
const currentTime = ref(0);
const totalTime = ref(0);

const emits = defineEmits(["close"]);

watch(
    () => props.show,
    (n, o) => {
        if (n) {
            showDialog.value = true;
        }
    }
);

const onTimeUpdate = (ev) => {
    currentTime.value = ev.target.currentTime;
};

const onLoadedMetadata = (ev) => {
    totalTime.value = ev.target.duration;
    ev.target.currentTime = props.video.current_time;
};

const onHide = async () => {
    if (props.video.principal && currentTime.value > props.video.current_time) {
        const send = useForm({
            id: props.video.id,
            last_time: currentTime.value,
            total_time: totalTime.value,
        });
        await send.post(`/admin/schooltopics/update-video-percentaje-to-user`);
    }
    emits("close");
};
</script>
