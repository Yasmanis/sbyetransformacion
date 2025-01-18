<template>
    <div class="row items-center q-pa-none q-mx-none">
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
            <label v-if="label" @click="fileRef.pickFiles()">{{ label }}</label>
            <q-img
                :src="image"
                @click="fileRef.pickFiles()"
                class="cursor-pointer"
                :ratio="hasDefaultImage ? 1 / 1 : ratio"
                :rules="fieldRules"
                :error="errorMsg !== null"
                :error-message="errorMsg"
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
        <!-- <ul
            style="padding: 0; margin-top: 0px; margin-bottom: 0px"
            v-if="fieldHelp?.length > 0"
        >
            <li
                v-for="(h, index) in fieldHelp"
                :key="`help-${index}`"
                style="list-style: none"
            >
                {{ h }}
            </li>
        </ul> -->
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
import { onBeforeMount, onMounted, computed, watch, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import { error } from "../../../helpers/notifications";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";
import { validations } from "../../../helpers/validations";

defineOptions({
    name: "ImageField",
});

const props = defineProps({
    modelValue: String,
    ratio: Number,
    label: String,
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
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    reset: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["change"]);
const page = usePage();
const fieldRules = ref([]);
const fieldHelp = ref([]);
const image = ref(null);
const file = ref(null);
const fileRef = ref(null);
const hasDefaultImage = ref(false);
const defaultImage = ref(
    `${page.props.public_path}images/icon/img-upload-${
        Dark.isActive ? "white" : "black"
    }.png`
);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

onMounted(() => {
    if (props.modelValue) {
        image.value = props.modelValue;
        hasDefaultImage.value = false;
    } else {
        image.value = defaultImage.value;
        hasDefaultImage.value = true;
    }
});

watch(
    () => props.reset,
    (n, o) => {
        if (n) resetImg();
    }
);

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

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
