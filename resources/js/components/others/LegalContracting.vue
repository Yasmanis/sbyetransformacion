<template>
    <span class="cursor-pointer" @click.stop="showDialog = true">
        <span v-html="text"></span>
        <q-tooltip-component title="click para ver terminos legales"
    /></span>
    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 900px; max-width: 1000vw">
            <dialog-header-component
                icon="mdi-gavel"
                title="terminos legales de contratacion"
                closable
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
import { onMounted, ref } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import QTooltipComponent from "../base/QTooltipComponent.vue";
import axios from "axios";

defineOptions({
    name: "LegalContracting",
});

const props = defineProps({
    text: {
        type: String,
        default: "terminos legales",
    },
});

const terms = ref(null);

onMounted(async () => {
    const result = await axios.post("/config/conditions");
    if (result) {
        terms.value = result.data.value;
    }
});

const showDialog = ref(false);
</script>
