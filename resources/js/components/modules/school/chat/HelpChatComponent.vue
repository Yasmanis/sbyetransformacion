<template>
    <btn-help-component tooltips="ayuda del chat" @click="showDialog = true" />
    <q-dialog
        v-model="showDialog"
        persistent
        width="400px"
        allow-focus-outside
        @before-show="readonly = has_edit"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-help-circle-outline"
                title="ayuda del chat"
                closable
            />
            <q-card-section style="width: 500px">
                <q-layout view="lHh Lpr lFf" container style="height: 56vh">
                    <q-page-container>
                        <q-page>
                            <editor-field
                                v-model="help"
                                :saveBtn="true"
                                :cancelBtn="true"
                                name="help_chat"
                                maxHeight="50vh"
                                @save="save"
                                @cancel="readonly = true"
                            />
                            <q-page-sticky
                                position="top-right"
                                :offset="[30, 50]"
                                v-if="readonly && has_edit"
                            >
                                <btn-conf-component
                                    size="lg"
                                    @click="readonly = false"
                                />
                            </q-page-sticky>
                        </q-page>
                    </q-page-container>
                </q-layout>
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
import BtnConfComponent from "../../../btn/BtnConfComponent.vue";
import EditorField from "../../../form/input/EditorField.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

defineOptions({
    name: "HelpChatComponent",
});

const props = defineProps({
    has_edit: {
        type: Boolean,
        default: false,
    },
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
    router.post(
        "/admin/configuration/save",
        {
            keyName: name,
            keyValue: val,
        },
        {
            onSuccess: () => {
                readonly.value = true;
                help.value = val;
            },
        }
    );
};
</script>
