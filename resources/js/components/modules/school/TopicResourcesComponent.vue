<template>
    <q-list dense>
        <q-item>
            <q-item-section avatar>
                <q-icon
                    name="mdi-video"
                    color="primary"
                    v-if="principalVideo"
                ></q-icon>
                <q-btn-component
                    tooltips="añadir video"
                    icon="mdi-video-plus"
                    @click="showExplorer(true)"
                    v-else
                />
            </q-item-section>
            <q-item-section v-if="principalVideo">
                <q-item-label lines="1"
                    >{{ principalVideo.name }}
                    <q-tooltip
                        class="text-body2"
                        anchor="top middle"
                        self="bottom middle"
                        :offset="[5, 5]"
                        >{{ principalVideo.name }}</q-tooltip
                    >
                </q-item-label>
            </q-item-section>
            <q-item-section avatar class="q-pr-xs" v-if="principalVideo">
                <q-btn-component
                    tooltips="reemplazar"
                    icon="mdi-sync"
                    @click="showExplorer(true)"
                />
            </q-item-section>
            <q-item-section avatar class="q-ml-none" v-if="principalVideo">
                <q-btn-component
                    tooltips="eliminar"
                    color="red"
                    icon="mdi-trash-can-outline"
                    @click="file_video ? (file_video = null) : removeVideo()"
                />
            </q-item-section>
        </q-item>
        <q-item
            v-for="(r, indexResource) in resources"
            :key="`resource_${indexResource}`"
            :class="r.principal ? 'hidden' : ''"
        >
            <q-item-section avatar class="q-pr-xs" v-if="!r.principal">
                <q-icon name="mdi-file" color="primary"></q-icon>
            </q-item-section>
            <q-item-section v-if="!r.principal">
                <q-item-label lines="1"
                    >{{ r.name }}
                    <q-tooltip
                        class="text-body2"
                        anchor="top middle"
                        self="bottom middle"
                        :offset="[5, 5]"
                        >{{ r.name }}</q-tooltip
                    ></q-item-label
                >
            </q-item-section>
            <q-item-section side v-if="!r.principal">
                <q-btn-component
                    tooltips="reemplazar"
                    size="10px"
                    icon="mdi-sync"
                    @click="changeResource(indexResource)"
                />
            </q-item-section>
            <q-item-section side v-if="!r.principal">
                <q-btn-component
                    tooltips="eliminar"
                    color="red"
                    icon="mdi-trash-can-outline"
                    @click="removeResource(indexResource)"
                />
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section side>
                <q-btn-component
                    tooltips="añadir recurso"
                    icon="mdi-file-plus-outline"
                    @click="showExplorer(false)"
                /> </q-item-section
        ></q-item>
    </q-list>
    <q-file
        v-model="file_video"
        ref="file_ref_video"
        accept="video/mp4,video/webm,video/ogg"
        @rejected="onRejectedVideo"
        style="display: none"
    ></q-file>
    <q-file
        v-model="file_mresource"
        ref="file_ref_mresource"
        @update:model-value="onChangeResource"
        multiple
        style="display: none"
    ></q-file>
    <q-file
        v-model="file_sresource"
        ref="file_ref_sresource"
        @update:model-value="onChangeResource"
        style="display: none"
    ></q-file>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { error } from "../../../helpers/notifications";

defineOptions({
    name: "TopicResourcesComponent",
});

const props = defineProps({
    imgbase: String,
    topic: Number,
    resources: Array,
});

const emits = defineEmits([
    "change-resources",
    "change-video",
    "remove-resource",
]);

const file_video = ref(null);
const file_ref_video = ref(null);
const file_mresource = ref(null);
const file_ref_mresource = ref(null);
const file_sresource = ref(null);
const file_ref_sresource = ref(null);
const principalVideo = ref(null);
const sync_resource = ref(-1);
const onRejectedVideo = () => {
    error("archivo seleccionado no valido");
};
const onChangeResource = (files) => {
    emits("change-resources", {
        files: files,
        index: sync_resource.value,
        topic: props.topic,
    });
};
const showExplorer = (video) => {
    if (video) {
        file_ref_video.value.pickFiles();
    } else {
        file_ref_mresource.value.pickFiles();
    }
};
const changeResource = (index) => {
    sync_resource.value = index;
    file_ref_sresource.value.pickFiles();
};
const removeResource = (index) => {
    emits("remove-resource", { topic: props.topic, index: index });
};
const removeVideo = () => {
    emits("change-video", {
        file: null,
        topic: props.topic,
    });
};
watch(props.resources, () => {
    principalVideo.value = props.resources.find((r) => r.principal);
});
watch(file_video, () => {
    emits("change-video", {
        file: file_video.value,
        topic: props.topic,
    });
});
onMounted(() => {
    if (props.resources) {
        principalVideo.value = props.resources.find((r) => r.principal);
    }
});
</script>
