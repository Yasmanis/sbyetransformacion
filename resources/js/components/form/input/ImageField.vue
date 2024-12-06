<template>
    <div class="row items-center">
        <div
            class="column full-width full-height items-center q-pa-xs"
            :style="{
                border: `1px solid ${
                    Dark.isActive
                        ? 'rgba(255, 255, 255, 0.28)'
                        : 'rgba(0, 0, 0, 0.12)'
                }`,
            }"
        >
            <q-img
                :src="image"
                @click="fileRef.pickFiles()"
                class="cursor-pointer"
                :width="width"
                :height="height"
                fit="fill"
            >
                <template v-slot:error>
                    <div
                        class="absolute-full flex flex-center bg-negative text-white"
                    >
                        error al tratar de obtener la imagen
                    </div>
                </template>
            </q-img>
            <div class="col self-center q-mt-sm">
                <q-btn-component
                    tooltips="reemplazar"
                    icon="mdi-sync"
                    class="q-mr-xs"
                    @click="fileRef.pickFiles()"
                />
                <btn-delete-component
                    :tooltips="hasDefaultImage ? '' : 'eliminar'"
                    :disable="hasDefaultImage"
                    class="q-ml-xs"
                    @click="resetImg"
                />
            </div>
        </div>
        <br />
        <div class="col-sm-12 col-md-12" style="padding-left: 35px"></div>
        <q-file
            v-model="file"
            ref="fileRef"
            @update:model-value="onChangeFile"
            accept="image/*"
            @rejected="onRejected"
            style="display: none"
        ></q-file>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import { error } from "../../../helpers/notifications";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

defineOptions({
    name: "ImageField",
});

const props = defineProps({
    modelValue: String,
    name: {
        type: String,
        required: true,
    },
    width: {
        type: String,
        default: "150px",
    },
    height: {
        type: String,
        default: "150px",
    },
});

const emits = defineEmits(["change"]);

const image = ref(null);
const file = ref(null);
const fileRef = ref(null);
const hasDefaultImage = ref(false);
const defaultImage = ref(
    `${usePage().props.public_path}images/icon/img-upload-${
        Dark.isActive ? "white" : "black"
    }.png`
);

onMounted(() => {
    if (props.modelValue) {
        image.value = props.modelValue;
        hasDefaultImage.value = false;
    } else {
        image.value = defaultImage.value;
        hasDefaultImage.value = true;
    }
});

const onChangeFile = (f) => {
    image.value = URL.createObjectURL(f);
    hasDefaultImage.value = false;
    emits("change", props.name, f);
};

const resetImg = () => {
    image.value = defaultImage.value;
    hasDefaultImage.value = true;
    file.value = null;
    emits("change", props.name, null);
};

const onRejected = (e) => {
    error("el fichero seleccionado no es una imagen");
};
</script>
