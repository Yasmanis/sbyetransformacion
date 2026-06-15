<template>
    <div
        ref="containerRef"
        class="chat-scroll-container"
        :style="{ height: containerHeight, overflowY: 'auto' }"
    >
        <q-list padding>
            <q-item
                v-for="(m, idx) in messages"
                :key="m.id"
                :ref="(el) => setMessageRef(el, idx)"
                :id="`chat-${m.id}-${m.topic_id}-${m.section_id}`"
                class="chat-message-item"
            >
                <q-item-section top avatar v-if="m.owner">
                    <q-avatar font-size="32px" icon="mdi-account-circle" />
                </q-item-section>

                <q-item-section
                    class="bg-white q-pa-sm"
                    style="
                        border-top-left-radius: 5px;
                        border-bottom-left-radius: 5px;
                    "
                >
                    <q-item-label
                        v-if="m.owner_visible && !m.owner"
                        overline
                        style="color: rgb(64, 116, 146)"
                        :style="{ 'text-align': m.owner ? 'left' : 'right' }"
                    >
                        {{ m.from_name ?? "sad" }}
                    </q-item-label>

                    <q-item-label
                        class="custom-font-size"
                        :id="`chat-message-${m.id}`"
                    >
                        <text-truncate :text="m.message" />
                    </q-item-label>

                    <template v-if="m.attachments.length > 0 && m.showAttach">
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
                            >
                                {{ a.name }}
                            </a>
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
                                v-if="m.reacts.length > 0"
                                class="text-body2"
                                anchor="top middle"
                                self="bottom middle"
                                :offset="[5, 5]"
                            >
                                {{
                                    m.reacts.length === 1
                                        ? "un usuario ha reaccionado a este mensaje"
                                        : `${m.reacts.length} usuarios han reaccionado a este mensaje`
                                }}
                            </q-tooltip>
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
                                <q-list dense padding style="width: 250px">
                                    <q-item
                                        v-for="(r, reactIndex) in m.reacts"
                                        :key="`react_${reactIndex}`"
                                    >
                                        <q-item-section avatar>
                                            <q-avatar
                                                font-size="32px"
                                                icon="mdi-account-circle"
                                            />
                                        </q-item-section>
                                        <q-item-section
                                            >{{ r.name }}
                                            {{ r.last_name }}</q-item-section
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
                                v-if="m.highligths.length > 0"
                                class="text-body2"
                                anchor="top middle"
                                self="bottom middle"
                                :offset="[5, 5]"
                            >
                                {{
                                    m.highligths.length === 1
                                        ? "un usuario ha destacado este mensaje"
                                        : `${m.highligths.length} usuarios han destacado este mensaje`
                                }}
                            </q-tooltip>
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
                                <q-list dense padding style="width: 250px">
                                    <q-item
                                        v-for="(r, hlIndex) in m.highligths"
                                        :key="`highligth_${hlIndex}`"
                                    >
                                        <q-item-section avatar>
                                            <q-avatar
                                                font-size="32px"
                                                icon="mdi-account-circle"
                                            />
                                        </q-item-section>
                                        <q-item-section
                                            >{{ r.name }}
                                            {{ r.last_name }}</q-item-section
                                        >
                                    </q-item>
                                </q-list>
                            </q-menu>
                        </q-btn>

                        <chat-response-component :message="m" />
                    </q-item-label>

                    <chat-actions-component
                        :message="m"
                        @reload="emits('reload')"
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
                        :up="m.showAttach === undefined ? true : !m.showAttach"
                        @click="m.showAttach = !m.showAttach"
                        v-if="m.attachments.length > 0"
                    />
                </q-item-section>

                <q-item-section avatar v-if="!m.owner">
                    <q-avatar font-size="32px" icon="mdi-account-circle" />
                </q-item-section>
            </q-item>
        </q-list>
    </div>
</template>

<script setup>
import { ref, watch, nextTick, onMounted, onUnmounted } from "vue";
import BtnDownUpComponent from "../../../btn/BtnDownUpComponent.vue";
import ChatActionsComponent from "./ChatActionsComponent.vue";
import TextTruncate from "../../../others/TextTruncate.vue";
import ChatResponseComponent from "./ChatResponseComponent.vue";

defineOptions({ name: "ChatMessageComponent" });

const emits = defineEmits(["reload"]);

const props = defineProps({
    messages: {
        type: Array,
        default: () => [],
    },
    showActions: {
        type: Boolean,
        default: true,
    },
    fullHeight: Boolean,
    showChat: String,
});

const containerRef = ref(null);
const messageRefs = ref([]);
const containerHeight = ref("auto");

const setMessageRef = (el, index) => {
    if (el) {
        messageRefs.value[index] = el;
    }
};

const updateHeight = async () => {
    if (!props.fullHeight) {
        await nextTick();
        const items = document.querySelectorAll(".chat-message-item");

        if (items.length >= 2) {
            const first = items[0];
            const second = items[1];

            const firstHeight = first.offsetHeight;
            const secondHeight = second.offsetHeight;

            const firstStyle = getComputedStyle(first);
            const secondStyle = getComputedStyle(second);
            const marginBottomFirst = parseFloat(firstStyle.marginBottom) || 0;
            const marginTopSecond = parseFloat(secondStyle.marginTop) || 0;

            const totalHeight =
                firstHeight +
                marginBottomFirst +
                marginTopSecond +
                secondHeight;

            const qList = document.querySelector(".q-list");
            let listPadding = 0;
            if (qList) {
                const listStyle = getComputedStyle(qList);
                listPadding =
                    parseFloat(listStyle.paddingTop) +
                    parseFloat(listStyle.paddingBottom);
            }

            containerHeight.value = `${totalHeight + listPadding + 4}px`;
        } else if (items.length === 1) {
            const firstHeight = items[0].offsetHeight;
            containerHeight.value = `${firstHeight + 40}px`;
        } else {
            containerHeight.value = "100px";
        }
    }
};

watch(
    () => props.messages,
    async () => {
        await updateHeight();
        nextTick(() => {
            console.log(containerRef.value);

            if (props.showChat) {
                let el = document.getElementById(props.showChat);
                if (el) {
                    el.scrollIntoView({ behavior: "smooth", block: "center" });
                    window.location.hash = "";
                }
            }
        });
    },
    { deep: true, immediate: true },
);

let resizeObserver = null;
onMounted(() => {
    updateHeight();
    resizeObserver = new ResizeObserver(() => updateHeight());
    if (containerRef.value) resizeObserver.observe(containerRef.value);
});

onUnmounted(() => {
    if (resizeObserver) resizeObserver.disconnect();
});
</script>

<style scoped>
.chat-scroll-container {
    transition: height 0.1s ease;
}
</style>
