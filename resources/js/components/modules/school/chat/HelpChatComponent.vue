<template>
    <btn-help-component tooltips="ayuda del chat" @click="showDialog = true" />
    <q-dialog v-model="showDialog" persistent>
        <q-card>
            <dialog-header-component
                icon="mdi-help-circle-outline"
                title="ayuda del chat"
                closable
            />
            <q-card-section>
                <q-btn label="asd" @click="readonly = !readonly" />
                <editor-field
                    v-model="help"
                    :saveBtn="true"
                    name="help"
                    :readonly="readonly"
                    @update="
                        (name, val) => {
                            help = val;
                        }
                    "
                    @save="save"
                />
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, onBeforeMount } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnHelpComponent from "../../../btn/BtnHelpComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import EditorField from "../../../form/input/EditorField.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

defineOptions({
    name: "HelpChatComponent",
});

const showDialog = ref(false);
const help = ref(null);
const readonly = ref(false);

onBeforeMount(() => {
    axios
        .get("/admin/configuration/index/help_chat")
        .then((data) => {
            help.value = data.data.value ?? "";
        })
        .catch(() => {});
});

const save = (name, val) => {
    router.post("/admin/configuration/save", {
        keyName: "help_chat",
        keyValue: help.value,
    });
};
</script>
