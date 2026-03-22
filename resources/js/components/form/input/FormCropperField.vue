<template>
    <div class="column items-center">
        <q-avatar
            :size="size"
            :square="square"
            class="cursor-pointer"
            :class="{
                'shadow-10': !square,
            }"
            @click="openCropper"
        >
            <img
                :src="
                    modelValue ??
                    `${$page.props.public_path}images/icon/img-upload-${
                        Dark.isActive ? 'white' : 'black'
                    }.png`
                "
            />
        </q-avatar>
        <q-btn-component
            tooltips="eliminar"
            icon="mdi-trash-can-outline"
            :flat="false"
            color="dark"
            round
            size="sm"
            style="position: absolute; right: -5px"
            @click="onFinishCropper(name, null)"
            v-if="modelValue"
        />
    </div>

    <q-dialog v-model="showDialog" @hide="file = null">
        <q-card style="width: 600px">
            <q-card-section>
                <cropper-field
                    :name="name"
                    :image="copperImage"
                    :square="square"
                    :avatar="!square"
                    @cancel="showDialog = false"
                    @finish="onFinishCropper"
                />
            </q-card-section>
        </q-card>
    </q-dialog>

    <q-file
        v-model="file"
        ref="fileRef"
        class="hidden"
        accept=".jpg, image/*"
        @update:model-value="handleFile"
    />
</template>

<script setup>
import { onMounted, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import CropperField from "./CropperField.vue";
import { Dark } from "quasar";

defineOptions({
    name: "FormCropperField",
});

const props = defineProps({
    modelValue: String,
    name: {
        type: String,
        default: "image",
    },
    size: {
        type: String,
        default: "120px",
    },
    square: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["update"]);

const file = ref(null);
const fileRef = ref(null);
const showDialog = ref(false);
const copperImage = ref(null);

onMounted(() => {});

const openCropper = () => {
    if (props.modelValue) {
        copperImage.value = props.modelValue;
        showDialog.value = true;
    } else {
        fileRef.value.pickFiles();
    }
};

const handleFile = (file) => {
    copperImage.value = URL.createObjectURL(file);
    showDialog.value = true;
};

const onFinishCropper = (name, img) => {
    emits("update", name, img);
    showDialog.value = false;
};
</script>
