<template>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 self-center">
            <div class="column items-center">
                <q-avatar size="120px" class="shadow-10 cursor-pointer" @click="openCropper">
                    <img :src="image" />
                </q-avatar>
                <btn-delete-component tooltips="quitar avatar" @click="onFinishCropper('avatar', null)"
                    v-if="user.avatar" />
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
            <q-list>
                <q-item>
                    <q-item-section>
                        <q-item-label> usuario </q-item-label>
                        <q-item-label caption>
                            {{ user.username }}
                        </q-item-label>
                    </q-item-section> </q-item><q-item>
                    <q-item-section>
                        <q-item-label> nombre(s) </q-item-label>
                        <q-item-label caption>
                            {{ user.name }}
                        </q-item-label>
                    </q-item-section> </q-item><q-item>
                    <q-item-section>
                        <q-item-label> apellidos </q-item-label>
                        <q-item-label caption>
                            {{ user.surname }}
                        </q-item-label>
                    </q-item-section> </q-item><q-item>
                    <q-item-section>
                        <q-item-label> correo </q-item-label>
                        <q-item-label caption>
                            {{ user.email }}
                        </q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </div>
    </div>

    <q-dialog v-model="showDialog" @hide="file = null">
        <q-card style="width: 600px;">
            <q-card-section>
                <cropper-field name="avatar" :image="copperImage" avatar @cancel="showDialog = false"
                    @finish="onFinishCropper" />
            </q-card-section>
        </q-card>
    </q-dialog>

    <q-file v-model="file" ref="fileRef" class="hidden" accept=".jpg, image/*" @update:model-value="handleFile" />
</template>

<script setup>
import { onMounted, computed, ref } from "vue";
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import CropperField from "../form/input/CropperField.vue";

defineOptions({
    name: "InfoComponent",
});
const page = usePage();
const file = ref(null);
const fileRef = ref(null);
const showDialog = ref(false);
const image = ref(null);
const copperImage = ref(null);

onMounted(() => {
    image.value = page.props.auth.user.avatar ?? `${page.props.public_path}images/icon/profile.svg`
});

const user = computed(() => {
    return page.props.auth.user;
});

const openCropper = () => {
    if (user.value.avatar) {
        copperImage.value = user.value.avatar;
        showDialog.value = true;
    }
    else {
        fileRef.value.pickFiles();
    }
};

const handleFile = (file) => {
    copperImage.value = URL.createObjectURL(file);
    showDialog.value = true;
};

const onFinishCropper = (name, img) => {
    const form = useForm({
        'avatar': img
    }).post('/auth/profile', {
        onSuccess: () => {
            image.value = img ? img : `${page.props.public_path}images/icon/profile.svg`;
            showDialog.value = false;
        }
    });

};
</script>
