<template>
    <q-card class="bg-grey-4 q-px-md q-mt-sm">
        <q-card-section class="no-padding">
            <q-list>
                <q-item style="padding: 0">
                    <q-item-section
                        @click="showPanel = !showPanel"
                        class="cursor-pointer"
                    >
                        <q-item-label lines="1" class="text-bold">
                            preguntanos o comenta lo que quieras
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar>
                        <btn-down-up-component
                            :up="!showPanel"
                            @click="showPanel = !showPanel"
                        />
                    </q-item-section>
                    <q-item-section avatar>
                        <btn-delete-component
                            flat
                            tooltips="resetear chat, borrar todos los mensajes"
                            @click="confirm = true"
                            :disable="messages.length === 0"
                        />
                    </q-item-section>
                    <!-- <q-item-section avatar>
                <btn-play-component flat tooltips="activar chat" />
            </q-item-section> -->
                    <q-item-section avatar>
                        <btn-left-right-component
                            title="tema anterior"
                            :disable="index === 0"
                            @click="emits('change-topic', index - 1)"
                        />
                    </q-item-section>
                    <q-item-section avatar>
                        <btn-left-right-component
                            :leftDirection="false"
                            title="tema siguiente"
                            :disable="
                                index === section?.topics.length - 1 ||
                                (!$page.props.auth.user.sa &&
                                    !$page.props.auth.permissions.includes(
                                        `full_${segment}`,
                                    ) &&
                                    topic?.percent < 95 &&
                                    segment === 'learning' &&
                                    topic?.has_principal_video)
                            "
                            @click="emits('change-topic', index + 1)"
                        />
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
        <q-card-section class="no-padding chat-panel" v-show="showPanel">
            <div
                class="q-mb-sm bg-white"
                style="height: 30px; margin-top: 10px"
                v-if="messages.length === 0"
            >
                <q-tooltip
                    :offset="[-15, -15]"
                    max-width="400px"
                    style="
                        color: black !important;
                        background-color: #d2ffde;
                        font-size: 14px;
                    "
                >
                    <q-item style="padding: 0">
                        <q-item-section avatar>
                            <q-icon
                                name="mdi-information-outline"
                                size="22px"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label
                                >pulsa el boton usar chat
                                <q-icon
                                    name="mdi-chat-processing-outline"
                                    size="22px"
                                ></q-icon>
                                para escribir tu mensaje, si es la primera vez
                                que usas el chat lee las instrucciones en
                                <q-icon
                                    name="mdi-help-circle-outline"
                                    size="22px"
                            /></q-item-label>
                        </q-item-section>
                    </q-item>
                </q-tooltip>
            </div>
            <div class="messages" v-else>
                <chat-message-component
                    :messages="messages"
                    :show-chat="showChat"
                    @reload="loadMessages(topic)"
                />
            </div>
            <btn-reload-component
                :loading="loading"
                @click="loadMessages(topic)"
            />
            <form-chat-component
                :topic="props.topic"
                @reload="loadMessages(topic)"
            />
            <help-chat-component :has_edit="has_edit" />
        </q-card-section>
        <q-inner-loading
            :showing="loading"
            label-class="text-primary"
            color="primary"
            size="xs"
        />
    </q-card>

    <confirm-component
        :show="confirm"
        @ok="
            router.post(
                `/admin/schooltopics/clear-chat/${topic?.id}`,
                {},
                { onSuccess: () => (confirm = false) },
            )
        "
        @hide="confirm = false"
        title="limpiar chat"
        message="seguro que deseas limpiar el chat de este tema"
    />
</template>

<script setup>
import { computed, ref, watch } from "vue";
import BtnDownUpComponent from "../../../btn/BtnDownUpComponent.vue";
import BtnLeftRightComponent from "../../../btn/BtnLeftRightComponent.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnPlayComponent from "../../../btn/BtnPlayComponent.vue";
import HelpChatComponent from "./HelpChatComponent.vue";
import FormChatComponent from "./FormChatComponent.vue";
import ChatMessageComponent from "./ChatMessageComponent.vue";
import BtnReloadComponent from "../../../btn/BtnReloadComponent.vue";
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

defineOptions({
    name: "ChatComponent",
});

const props = defineProps({
    topic: Object,
    section: Object,
    index: {
        type: Number,
        default: 0,
    },
    save: {
        type: Boolean,
        default: false,
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
    showChat: String,
    segment: String,
});

const showPanel = ref(true);
const messages = ref([]);
const emits = defineEmits(["change-topic"]);
const confirm = ref(false);
const loading = ref(false);

watch(
    () => props.showChat,
    (n) => {
        showPanel.value = n !== null;
    },
);

watch(
    () => props.topic,
    (n, o) => {
        if (n?.id !== o?.id) {
            loadMessages(n);
        }
    },
);

const loadMessages = async (t) => {
    loading.value = true;
    await axios
        .post(`/admin/schooltopics/get-messages-from-topic/${t.id}`)
        .then((res) => {
            messages.value = res.data;
        })
        .finally(() => {
            loading.value = false;
        });
};

const clearChat = async () => {
    showLoading.value = true;
    await axios
        .post(`${props.url}/${props.base}/clear-chat/${props.topic}`)
        .then((response) => {
            let msgs = response.data.messages;
            msgs.forEach((m) => {
                if (m.attachments && m.attachments.length > 0) {
                    m["showAttach"] = false;
                }
                m["updating"] = false;
            });
            messages.value = msgs;
            showLoading.value = false;
            toastMsg("success", "chat reseteado correctamente");
        })
        .catch((error) => {
            showLoading.value = false;
            toastMsgErrorFromServer();
        });
};
</script>
