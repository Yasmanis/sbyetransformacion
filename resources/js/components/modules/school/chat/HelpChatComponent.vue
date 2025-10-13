<template>
    <btn-help-component tooltips="ayuda del chat" @click="showDialog = true" />
    <q-dialog
        v-model="showDialog"
        persistent
        width="400px"
        allow-focus-outside
        @hide="helpEdit = false"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-help-circle-outline"
                title="ayuda del chat"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <btn-conf-component
                    size="md"
                    @click="helpEdit = true"
                    class="absolute-top-right"
                    style="z-index: 1; margin-top: 30px; margin-right: 30px"
                />
                <editor-field
                    v-model="help"
                    :modelValue="help"
                    :saveBtn="true"
                    :cancelBtn="true"
                    :readonly="!helpEdit"
                    name="help_chat"
                    @save="saveHelp"
                    @cancel="
                        (name, val) => {
                            helpEdit = false;
                            help = val;
                        }
                    "
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
import BtnConfComponent from "../../../btn/BtnConfComponent.vue";
import EditorField from "../../../form/input/EditorField.vue";
import { useForm } from "@inertiajs/vue3";
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
const helpEdit = ref(false);
const defaultHelp = ref(null);

onBeforeMount(() => {
    axios
        .get("/admin/configuration/index/help_chat")
        .then((data) => {
            help.value = data.data.value ?? "";
            defaultHelp.value = data.data.value ?? "";
        })
        .catch(() => {});
});

const saveHelp = async (keyName, keyValue) => {
    const form = useForm({
        keyName,
        keyValue,
    });
    form.post("/admin/configuration/save", {
        onSuccess: () => {
            helpEdit.value = false;
        },
    });
};
</script>
