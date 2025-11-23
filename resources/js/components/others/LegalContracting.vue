<template>
    <span
        class="cursor-pointer"
        @click.stop="showDialog = true"
        v-if="showTitle"
    >
        <span v-html="text"></span>
        <q-tooltip-component :title="`click para ver ${title}`"
    /></span>
    <q-dialog v-model="showDialog" persistent @hide="emits('hide')">
        <q-card style="width: 900px; max-width: 1000vw">
            <dialog-header-component
                icon="mdi-gavel"
                :title="title"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 70vh" class="scroll">
                <span v-html="terms"></span>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import QTooltipComponent from "../base/QTooltipComponent.vue";
import axios from "axios";

defineOptions({
    name: "LegalContracting",
});

const props = defineProps({
    title: {
        type: String,
        default: "terminos legales de contratacion",
    },
    text: {
        type: String,
        default: "terminos legales",
    },
    keyName: {
        type: String,
        default: "conditions",
    },
    show: Boolean,
    showTitle: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["hide"]);

const terms = ref(null);

onMounted(async () => {
    const result = await axios.post(`/config/${props.keyName}`);
    if (result) {
        terms.value = result.data.value;
    }
});

const showDialog = ref(false);

watch(
    () => props.show,
    (n) => {
        showDialog.value = n;
    }
);
</script>
