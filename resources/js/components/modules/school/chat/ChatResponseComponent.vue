<template>
    <q-btn-component
        :icon="`img:${$page.props.public_path}images/icon/${Dark.isActive ? 'white' : 'black'}-chat-responses.png`"
        @click="showDialog = true"
        :disable="message.responses === 0"
        :tooltips="`cantidad de respuestas: ${message.responses}`"
    >
        <q-badge
            floating
            color="primary"
            style="margin-right: -3px; margin-top: -2px"
            >{{ message.responses }}</q-badge
        >
    </q-btn-component>
    <q-dialog
        v-model="showDialog"
        persistent
        width="400px"
        allow-focus-outside
        @before-show="onShow"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-chat-processing-outline"
                title="interacciones con el mensaje"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div class="col bg-grey-4 q-pa-md rounded-borders">
                        <chat-text-truncate :text="message.message" />
                    </div>
                </div>
                <div>
                    <chat-message-component
                        :messages="messages"
                        full-height
                        @reload="onShow"
                    />
                    <q-inner-loading
                        :showing="loading"
                        label-class="text-primary"
                        color="primary"
                        size="xs"
                    ></q-inner-loading>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import QTooltipComponent from "../../../base/QTooltipComponent.vue";
import ChatMessageComponent from "./ChatMessageComponent.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import ChatTextTruncate from "./ChatTextTruncate.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import { ref, watch } from "vue";
import axios from "axios";
import { Dark } from "quasar";

defineOptions({
    name: "ChatResponseComponent",
});

const props = defineProps({
    topic: {
        type: Object,
    },
    message: {
        type: Object,
        required: true,
    },
    showActions: {
        type: Boolean,
        default: true,
    },
});

const showDialog = ref(false);
const messages = ref([]);
const loading = ref(false);

watch(
    () => props.topic,
    (n) => {
        onShow();
    },
    {
        deep: true,
    },
);

const onShow = async () => {
    loading.value = true;
    axios
        .post("/admin/schooltopics/get-messages-from-parent", {
            reply_to: props.message.id,
        })
        .then((res) => {
            messages.value = res.data.messages;
        })
        .finally(() => {
            loading.value = false;
        });
};
</script>
