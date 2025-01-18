<template>
    <div class="row q-col-gutter-md">
        <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
            <div class="row">
                <VuePictureCropper :boxStyle="{
                    width: '100%',
                    height: '100%',
                    backgroundColor: '#f8f8f8',
                    margin: 'auto',
                }" :img="imageCropper" :options="{
    viewMode: 1,
    dragMode: 'crop',
    aspectRatio: 16 / 9,
}" @crop="imagePreview = cropper.getDataURL()" />
            </div>
            <div class="col text-center q-pt-md">
                <q-btn-component icon="upload" tooltips="cambiar imagen" @click="fileRef.pickFiles()" />
                <q-btn-component icon="rotate_left" tooltips="rotar a la izquierda" @click="rotateLeft" />
                <q-btn-component icon="rotate_right" tooltips="rotar a la derecha" @click="rotateRight" />
                <q-btn-component icon="settings_backup_restore" tooltips="restaurar" @click="resetCropper" />
                <btn-cancel-component cancel @click="cancel" />
                <btn-confirm-component tooltips="recortar y finalizar" @click="finish" />
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 self-center">
            <div class="column items-center">
                <q-avatar size="120px" class="shadow-10" v-if="avatar">
                    <img :src="imagePreview" />
                </q-avatar>
                <img :src="imagePreview" style="width: 100%; height: 100%" v-else />
            </div>
            <div class="col text-center q-pt-md">vista previa</div>
        </div>
    </div>

    <q-file v-model="file" ref="fileRef" class="hidden" accept=".jpg, image/*" @update:model-value="handleFile" />
</template>

<script setup>
import { ref, onBeforeMount, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import VuePictureCropper, { cropper } from "vue-picture-cropper";
defineOptions({
    name: "CropperField",
});

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    image: String,
    avatar: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["cancel", "finish"]);
const imageCropper = ref(null);
const imagePreview = ref(null);
const file = ref(null);
const fileRef = ref(null);

onBeforeMount(() => {
    imageCropper.value = props.image;
});

const handleFile = (file) => {
    imageCropper.value = URL.createObjectURL(file);
};

const resetCropper = () => {
    cropper.reset();
};

const rotateLeft = () => {
    cropper.rotate(-90);
};

const rotateRight = () => {
    cropper.rotate(90);
};

const cancel = () => {
    emits("cancel");
};

const finish = () => {
    emits("finish", props.name, imagePreview.value);
};
</script>
