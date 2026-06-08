<template>
    <div id="chat-scroll-box" class="chat-scroll-container">
        <q-infinite-scroll
            @load="onLoad"
            :offset="50"
            scroll-target="#chat-scroll-box"
        >
            <q-list padding>
                <transition-group name="chat-fade">
                    <q-item
                        v-for="m in visibleMessages"
                        :key="m.id"
                        :id="`chat-${m.id}-${m.topic_id}-${m.section_id}`"
                    >
                        <q-item-section top avatar v-if="m.owner">
                            <q-avatar
                                font-size="32px"
                                icon="mdi-account-circle"
                            ></q-avatar>
                        </q-item-section>

                        <q-item-section
                            class="bg-white q-pa-sm"
                            style="
                                border-top-left-radius: 5px;
                                border-bottom-left-radius: 5px;
                            "
                        >
                            <q-item-label
                                overline
                                style="color: rgb(64, 116, 146)"
                                :style="{
                                    'text-align': m.owner ? 'left' : 'right',
                                }"
                                v-if="m.owner_visible && !m.owner"
                            >
                                {{ m.from_name ?? "sad" }}
                            </q-item-label>

                            <q-item-label
                                style="
                                    border-radius: 4px;
                                    padding: 5px;
                                    border-left: 4px solid rgb(64, 116, 146);
                                    background-color: lightgray;
                                "
                                class="cursor-pointer"
                                @click="scrollToElement(m.reply_to.id)"
                                v-if="m.reply_to"
                            >
                                <p
                                    style="
                                        color: rgb(64, 116, 146);
                                        margin-bottom: 0px !important;
                                    "
                                    v-if="m.owner_reply"
                                >
                                    tu
                                </p>
                                <p
                                    style="
                                        color: rgb(64, 116, 146);
                                        margin-bottom: 0px !important;
                                    "
                                    v-else-if="m.owner_visible"
                                >
                                    {{ m.reply_to_user ?? "anonimo" }}
                                </p>
                                <div
                                    v-html="m.reply_to_msg"
                                    class="chat-html-truncate"
                                ></div>
                            </q-item-label>

                            <q-item-label
                                :id="`chat-message-${m.id}`"
                                style="font-size: 14px"
                            >
                                <text-truncate :text="m.message" />
                            </q-item-label>

                            <template
                                v-if="m.attachments.length > 0 && m.showAttach"
                            >
                                <q-item-label
                                    caption
                                    class="q-ml-sm"
                                    v-for="(a, indexAttach) in m.attachments"
                                    :key="`attach_${indexAttach}`"
                                >
                                    <a
                                        :href="`${$page.props.public_path}storage/${a.path}`"
                                        target="_blank"
                                        class="caption text-primary"
                                        style="text-decoration: none"
                                        >{{ a.name }}</a
                                    >
                                </q-item-label>
                            </template>

                            <q-item-label class="q-pt-sm">
                                <q-btn
                                    dense
                                    flat
                                    icon="mdi-emoticon-happy-outline"
                                    :disable="m.reacts.length == 0"
                                >
                                    <q-tooltip
                                        class="text-body2"
                                        anchor="top middle"
                                        self="bottom middle"
                                        :offset="[5, 5]"
                                        v-if="m.reacts.length > 0"
                                        >{{
                                            m.reacts.length === 1
                                                ? "un usuario ha reaccionado a este mensaje"
                                                : `${m.reacts.length} usuarios han reaccionado a este mensaje`
                                        }}</q-tooltip
                                    >
                                    <q-badge
                                        floating
                                        color="primary"
                                        style="margin-right: -3px"
                                        >{{ m.reacts.length }}</q-badge
                                    >
                                    <q-menu
                                        transition-show="jump-down"
                                        transition-hide="jump-up"
                                    >
                                        <q-list
                                            dense
                                            padding
                                            style="width: 250px"
                                        >
                                            <q-item
                                                v-for="(
                                                    r, reactIndex
                                                ) in m.reacts"
                                                :key="`react_${reactIndex}`"
                                            >
                                                <q-item-section avatar>
                                                    <q-avatar
                                                        font-size="32px"
                                                        icon="mdi-account-circle"
                                                    ></q-avatar>
                                                </q-item-section>
                                                <q-item-section
                                                    >{{ r.name }}
                                                    {{
                                                        r.last_name
                                                    }}</q-item-section
                                                >
                                            </q-item>
                                        </q-list>
                                    </q-menu>
                                </q-btn>

                                <q-btn
                                    dense
                                    flat
                                    icon="mdi-star-outline"
                                    :disable="m.highligths.length == 0"
                                >
                                    <q-tooltip
                                        class="text-body2"
                                        anchor="top middle"
                                        self="bottom middle"
                                        :offset="[5, 5]"
                                        v-if="m.highligths.length > 0"
                                        >{{
                                            m.highligths.length === 1
                                                ? "un usuario ha destacado a este mensaje"
                                                : `${m.highligths.length} usuarios han destacado a este mensaje`
                                        }}</q-tooltip
                                    >
                                    <q-badge
                                        floating
                                        color="primary"
                                        style="margin-right: -3px"
                                        >{{ m.highligths.length }}</q-badge
                                    >
                                    <q-menu
                                        transition-show="jump-down"
                                        transition-hide="jump-up"
                                    >
                                        <q-list
                                            dense
                                            padding
                                            style="width: 250px"
                                        >
                                            <q-item
                                                v-for="(
                                                    r, highligthIndex
                                                ) in m.highligths"
                                                :key="`highligth_${highligthIndex}`"
                                            >
                                                <q-item-section avatar>
                                                    <q-avatar
                                                        font-size="32px"
                                                        icon="mdi-account-circle"
                                                    ></q-avatar>
                                                </q-item-section>
                                                <q-item-section
                                                    >{{ r.name }}
                                                    {{
                                                        r.last_name
                                                    }}</q-item-section
                                                >
                                            </q-item>
                                        </q-list>
                                    </q-menu>
                                </q-btn>
                            </q-item-label>

                            <chat-actions-component
                                :message="m"
                                v-if="showActions"
                            />
                        </q-item-section>

                        <q-item-section
                            avatar
                            top
                            class="bg-white no-padding"
                            style="
                                border-top-right-radius: 5px;
                                border-bottom-right-radius: 5px;
                            "
                        >
                            <btn-down-up-component
                                titleUp="ocultar adjuntos"
                                titleDown="mostrar adjuntos"
                                :up="
                                    m.showAttach === undefined
                                        ? true
                                        : !m.showAttach
                                "
                                @click="m.showAttach = !m.showAttach"
                                v-if="m.attachments.length > 0"
                            />
                        </q-item-section>

                        <q-item-section avatar v-if="!m.owner">
                            <q-avatar
                                font-size="32px"
                                icon="mdi-account-circle"
                            ></q-avatar>
                        </q-item-section>
                    </q-item>
                </transition-group>
            </q-list>

            <template v-slot:loading>
                <div class="row justify-center q-my-md">
                    <q-spinner-dots color="primary" size="40px" />
                </div>
            </template>
        </q-infinite-scroll>
    </div>
</template>

<script setup>
import BtnDownUpComponent from "../../../btn/BtnDownUpComponent.vue";
import ChatActionsComponent from "./ChatActionsComponent.vue";
import TextTruncate from "../../../others/TextTruncate.vue";
import { scroll } from "quasar";
import { ref, watch } from "vue";

defineOptions({
    name: "ChatMessageComponent",
});

const props = defineProps({
    messages: {
        type: Array,
        default: () => [],
    },
    showActions: {
        type: Boolean,
        default: true,
    },
    showChat: String,
});

const visibleMessages = ref([]);
const itemsPerPage = 2;

const onLoad = (index, done) => {
    if (!props.messages || props.messages.length === 0) {
        done();
        return;
    }

    const currentLength = visibleMessages.value.length;

    if (currentLength >= props.messages.length) {
        done(true);
        return;
    }
    setTimeout(() => {
        const nextItems = props.messages.slice(
            currentLength,
            currentLength + itemsPerPage,
        );
        if (nextItems.length > 0) {
            visibleMessages.value.push(...nextItems);
        }
        if (visibleMessages.value.length >= props.messages.length) {
            done(true);
        } else {
            done();
        }
    }, 300);
};

watch(
    () => props.messages,
    (newMessages) => {
        if (newMessages && newMessages.length > 0) {
            if (visibleMessages.value.length === 0) {
                visibleMessages.value = newMessages.slice(0, itemsPerPage);
            }
        } else {
            visibleMessages.value = [];
        }
    },
    { immediate: true },
);

const scrollToElement = (id) => {
    const el = document.getElementById(`chat-message-${id}`);
    if (el) {
        el.scrollIntoView({ behavior: "smooth", block: "center" });
    }
};
</script>

<style scoped>
.chat-scroll-container {
    height: 40vh;
    overflow-y: auto;
}
.chat-html-truncate :deep(*) {
    display: inline;
}
.chat-html-truncate {
    display: block;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    width: 100%;
}

/* =========================================================================
   2. ESTILOS DE LA ANIMACIÓN (Transition-Group)
   ========================================================================= */
.chat-fade-enter-active {
    transition: all 0.4s ease-out;
}

/* Estado inicial: El mensaje aparece invisible y desplazado 20px hacia abajo */
.chat-fade-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

/* Estado final: Su posición original y opacidad total */
.chat-fade-enter-to {
    opacity: 1;
    transform: translateY(0);
}
</style>
