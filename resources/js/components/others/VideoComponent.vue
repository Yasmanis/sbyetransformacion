<template>
    <div>
        <video
            :src="src"
            :muted="muted"
            :autoplay="autoplay"
            :controls="controls"
            :loop="loop"
            :poster="poster"
            :preload="preload"
            :playsinline="true"
            ref="player"
        />
        <slot
            name="controls"
            *:play="play"
            :pause="pause"
            :playing="playing"
            :toggle-play="togglePlay"
            :video-muted="videoMuted"
            :toggle-mute="toggleMute"
            *
        ></slot>

        <q-btn icon="mdi-play" @click="play" />
    </div>
</template>

<script setup>
import { ref } from "vue";

defineOptions({
    name: "VideoComponent",
});

const props = defineProps({
    src: { type: String, required: true },
    controls: { type: Boolean, required: false, default: true },
    loop: { type: Boolean, required: false, default: false },
    autoplay: { type: Boolean, required: false, default: false },
    muted: { type: Boolean, required: false, default: false },
    poster: { type: String, required: false },
    preload: { type: String, required: false, default: "auto" },
});

const player = ref(null);

const playing = ref(false);
const videoMuted = ref(false);

const play = () => {
    player.value.play();
    setPlaying(true);
};

const pause = () => {
    player.pause();
    setPlaying(false);
};

const togglePlay = () => {
    if (playing.value) {
        pause();
    } else {
        play();
    }
};

const setPlaying = (state) => {
    playing.value = state;
};

const mute = () => {
    player.muted = true;
    setMuted(true);
};

const unmute = () => {
    player.muted = false;
    setMuted(false);
};

const toggleMute = () => {
    if (videoMuted.value) {
        unmute();
    } else {
        mute();
    }
};

const setMuted = (state) => {
    videoMuted.value = state;
};
</script>
