<template>
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
                <btn-delete-component flat />
            </q-item-section>
            <q-item-section avatar>
                <btn-play-component flat tooltips="activar chat" />
            </q-item-section>
        </q-item>
    </q-list>
    <div class="chat-panel" v-show="showPanel">
        <div
            class="q-mb-sm"
            style="height: 30px; background-color: gainsboro; margin-top: 10px"
            v-if="topic?.messages.length === 0"
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
                        <q-icon name="mdi-information-outline" size="22px" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label
                            >pulsa el boton usar chat
                            <q-icon
                                name="mdi-chat-processing-outline"
                                size="22px"
                            ></q-icon>
                            para escribir tu mensaje, si es la primera vez que
                            usas el chat lee las instrucciones en
                            <q-icon name="mdi-help-circle-outline" size="22px"
                        /></q-item-label>
                    </q-item-section>
                </q-item>
            </q-tooltip>
        </div>
        <div class="messages" v-else>
            <chat-message-component :messages="topic?.messages" />
        </div>
        <q-btn-component
            icon="mdi-reload"
            tooltips="actualizar"
            flat
            size="md"
            padding="5px"
            @click="router.reload()"
        />
        <form-chat-component :topic="props.topic" />
        <help-chat-component />
    </div>
</template>

<script setup>
import { ref } from "vue";
import BtnDownUpComponent from "../../../btn/BtnDownUpComponent.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnPlayComponent from "../../../btn/BtnPlayComponent.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import HelpChatComponent from "./HelpChatComponent.vue";
import FormChatComponent from "./FormChatComponent.vue";
import ChatMessageComponent from "./ChatMessageComponent.vue";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "ChatComponent",
});

const props = defineProps({
    topic: Object,
    save: {
        type: Boolean,
        default: false,
    },
});

const showPanel = ref(false);
const messages = [];

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
