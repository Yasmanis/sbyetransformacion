<template>
    <q-dialog v-model="showDialog" persistent @hide="emits('hide')">
        <q-card
            :style="{
                width: width,
            }"
        >
            <dialog-header-component
                :icon="iconHeader"
                :title="title"
                :separator="false"
                closable
            />
            <q-card-section class="column items-center">
                <q-icon
                    :name="`img:${$page.props.public_path}images/icon/blue-ligth-alert.png`"
                    class="text-custom-blue"
                    size="160px"
                    style=""
                />
                <p
                    style="font-size: 20px"
                    class="text-center"
                    v-html="question"
                ></p>
                <span v-html="message" class="text-center"></span>
            </q-card-section>
            <q-card-actions align="center">
                <btn-confirm-component @click="emits('ok')" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import DialogHeaderComponent from "./DialogHeaderComponent.vue";
import BtnConfirmComponent from "../btn/BtnConfirmComponent.vue";
import { watch, ref } from "vue";

defineOptions({
    name: "ConfirmComponent",
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    question: {
        type: String,
        default: "estas seguro?",
    },
    message: {
        type: String,
        default: "confirma realizar esta accion",
    },
    iconHeader: {
        type: String,
        default: "mdi-trash-can-outline",
    },
    title: {
        type: String,
        default: "confirmar accion",
    },
    width: {
        type: String,
        default: "400px",
    },
});

const emits = defineEmits(["ok", "hide"]);

const showDialog = ref(false);

watch(
    () => props.show,
    (n, o) => {
        showDialog.value = n;
    }
);
</script>
