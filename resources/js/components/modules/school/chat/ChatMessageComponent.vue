<template>
    <q-list padding>
        <q-item v-for="(m, indexMsg) in messages" :key="`message_${indexMsg}`">
            <q-item-section top avatar v-if="m.owner">
                <q-avatar font-size="32px" icon="mdi-account-circle"></q-avatar>
            </q-item-section>

            <q-item-section
                class="bg-grey-4 q-pa-sm"
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
                    {{ m.from_name }}
                </q-item-label>
                <q-item-label
                    style="
                        border-radius: 4px;
                        padding: 5px;
                        border-left: 4px solid rgb(64, 116, 146);
                        background-color: lightgray;
                    "
                    v-if="m.reply_to_user"
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
                        {{ m.reply_to_user }}
                    </p>
                    <span v-html="m.reply_to_msg"></span>
                </q-item-label>
                <q-item-label v-html="m.message" />
                <template v-if="m.attachments.length > 0 && m.showAttach">
                    <q-item-label
                        caption
                        class="q-ml-sm"
                        v-for="(a, indexAttach) in m.attachments"
                        :key="`attach_${indexAttach}`"
                        :style="{
                            'margin-top': indexAttach === 0 ? '-10px' : '',
                        }"
                    >
                        <a
                            :href="`${$page.props.public_path}storage/${a.path}`"
                            target="_blank"
                            class="caption"
                            style="text-decoration: none"
                            >{{ a.name }}</a
                        >
                    </q-item-label>
                </template>
                <q-item-label
                    :class="
                        m.attachments.length > 0 && m.showAttach
                            ? 'q-pt-sm'
                            : ''
                    "
                >
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
                            <q-list dense padding style="width: 250px">
                                <q-item
                                    v-for="(r, reactIndex) in m.reacts"
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
                            <q-list dense padding style="width: 250px">
                                <q-item
                                    v-for="(r, highligthIndex) in m.highligths"
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
                                        {{ r.last_name }}</q-item-section
                                    >
                                </q-item>
                            </q-list>
                        </q-menu>
                    </q-btn>
                </q-item-label>
                <chat-actions-component :message="m" />
            </q-item-section>
            <q-item-section
                avatar
                top
                class="bg-grey-4 no-padding"
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
                <q-avatar font-size="32px" icon="mdi-account-circle"></q-avatar>
            </q-item-section>
        </q-item>
    </q-list>
</template>

<script setup>
import { onMounted } from "vue";
import BtnDownUpComponent from "../../../btn/BtnDownUpComponent.vue";
import ChatActionsComponent from "./ChatActionsComponent.vue";

defineOptions({
    name: "ChatMessageComponent",
});

const props = defineProps({
    messages: {
        type: Array,
        default: [],
    },
});

onMounted(() => {
    console.log(props.messages);
});
</script>
