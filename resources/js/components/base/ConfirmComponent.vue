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
                @close="showDialog = false"
                v-if="header"
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
                <btn-confirm-component
                    :icon="iconConfirm"
                    :size="iconConfirmSize"
                    :tooltips="iconConfirmTooltips"
                    @click="emits('ok')"
                />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                    v-if="cancel"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import DialogHeaderComponent from "./DialogHeaderComponent.vue";
import BtnConfirmComponent from "../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import { watch, ref } from "vue";

defineOptions({
    name: "ConfirmComponent",
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    header: {
        type: Boolean,
        default: true,
    },
    cancel: {
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
    iconConfirm: String,
    iconConfirmSize: String,
    iconConfirmTooltips: String,
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
