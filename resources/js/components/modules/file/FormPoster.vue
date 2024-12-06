<template>
    <q-btn-component
        icon="mdi-image-outline"
        tooltips="portada"
        :disable="!object.type.startsWith('video/')"
        @click="showDialog = true"
    />
    <q-dialog
        v-model="showDialog"
        persistent
        :position="position"
        :full-hight="fullHeight"
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-image-outline"
                title="portada"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <image-field
                        name="poster"
                        :modelValue="
                            object.poster
                                ? `${page.props.public_path}storage/${object.poster}`
                                : null
                        "
                        @change="onChangePoster"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import ImageField from "../../form/input/ImageField.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { success, errorValidation } from "../../../helpers/notifications";

const props = defineProps({
    size: {
        type: String,
        default: "xs",
    },
    object: {
        type: Object,
        default: null,
    },
    fieldToStr: {
        type: String,
        default: "id",
    },
    title: {
        type: String,
        default: "Object",
    },
    position: {
        type: String,
        default: "right",
    },
    fullHeight: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["save"]);

const upload = ref(false);
const showDialog = ref(false);
const setDefault = ref(false);

const form = useForm({
    poster: null,
});

const page = usePage();

const onHide = () => {
    setDefault.value = !setDefault.value;
    usePage().props.errors = {};
};

const onChangePoster = (name, image) => {
    form.poster = image;
};

const save = async () => {
    form.post(`/admin/files/poster/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};
</script>
