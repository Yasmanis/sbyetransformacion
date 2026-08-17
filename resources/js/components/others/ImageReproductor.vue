<template>
    <q-img :src="src" :ratio="ratio" :fit="fit">
        <div
            class="absolute-full text-subtitle2 flex flex-center"
            v-if="reproductor"
        >
            <q-btn-component
                :tooltips="iconReproductorTitle"
                :icon="iconReproductor"
                :color="iconReproductorColor"
                :size="iconReproductorSize"
            />
        </div>

        <template #error>
            <div class="absolute-full text-subtitle2 flex flex-center">
                <q-btn-component
                    :tooltips="iconReproductorTitle"
                    :icon="iconReproductor"
                    :color="iconReproductorColor"
                    :size="iconReproductorSize"
                    v-if="reproductor"
                />
            </div>
        </template>
    </q-img>
</template>
<script setup>
import QBtnComponent from "../base/QBtnComponent.vue";
defineProps({
    src: String,
    ratio: {
        type: Number,
        default: 1,
    },
    fit: {
        type: String,
        default: "fill",
    },
    iconReproductor: {
        type: String,
        default: "mdi-youtube",
    },
    iconReproductorColor: {
        type: String,
        default: "primary",
    },
    iconReproductorSize: {
        type: String,
        default: "primary",
    },
    iconReproductorTitle: {
        type: String,
        default: "reproducir",
    },
    reproductor: {
        type: Boolean,
        default: true,
    },
});
</script>
