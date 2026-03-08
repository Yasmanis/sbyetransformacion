<template>
    <div class="column items-center">
        <q-avatar
            :size="size"
            class="shadow-10 cursor-pointer"
            @click="openCropper"
        >
            <img :src="image" />
        </q-avatar>
        <q-btn-component
            tooltips="quitar avatar"
            icon="mdi-trash-can-outline"
            :flat="false"
            color="dark"
            round
            size="sm"
            style="position: absolute; right: -5px"
            @click="onFinishCropper('avatar', null)"
            v-if="user.avatar"
        />
    </div>

    <q-dialog v-model="showDialog" @hide="file = null">
        <q-card style="width: 600px">
            <q-card-section>
                <cropper-field
                    name="avatar"
                    :image="copperImage"
                    avatar
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
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import CropperField from "../form/input/CropperField.vue";

defineOptions({
    name: "FormAvatar",
});

const props = defineProps({
    user: Object,
    size: {
        type: String,
        default: "120px",
    },
});

const page = usePage();
const file = ref(null);
const fileRef = ref(null);
const showDialog = ref(false);
const image = ref(null);
const copperImage = ref(null);

onMounted(() => {
    image.value = props.user?.avatar
        ? `${page.props.public_path}storage/${props.user.avatar}`
        : `${page.props.public_path}images/icon/profile.svg`;
});

const openCropper = () => {
    if (props.user.avatar) {
        copperImage.value = `${page.props.public_path}storage/${props.user.avatar}`;
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
    useForm({
        avatar: img,
    }).post(`/auth/change-avatar/${props.user.id}`, {
        onSuccess: () => {
            image.value = img
                ? img
                : `${page.props.public_path}images/icon/profile.svg`;
            showDialog.value = false;
        },
    });
};
</script>
