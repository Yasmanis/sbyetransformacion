<template>
    <q-input dense outlined>
        <template #before>
            <btn-private-msg-component>
                <q-menu ref="msgMenu" persistent style="width: 400px">
                    <q-card class="q-pa-sm">
                        <q-card-section>
                            <q-btn
                                icon="close"
                                flat
                                dense
                                class="absolute-top-right"
                                id="btn-close-dialog"
                                @click="msgMenu.hide()"
                            >
                            </q-btn>
                            <q-item-label class="q-pa-sm text-center"
                                >mensajes privados</q-item-label
                            >
                        </q-card-section>
                        <q-separator />
                        <q-card-section style="max-height: 50vh" class="scroll">
                            <q-list v-if="messages.length > 0">
                                <q-item
                                    v-for="(m, indexMsg) in messages"
                                    :key="`msg_${indexMsg}`"
                                    :style="{
                                        'border-top':
                                            indexMsg !== 0
                                                ? '1px solid lightgray'
                                                : null,
                                    }"
                                >
                                    <q-item-section>
                                        <q-item-label
                                            ><q-icon
                                                name="circle"
                                                size="15px"
                                                :class="
                                                    !m.read ? 'text-danger' : ''
                                                "
                                            >
                                            </q-icon>
                                            <span
                                                :class="
                                                    !m.read ? 'text-danger' : ''
                                                "
                                                >{{
                                                    getFormatDate(m.created_at)
                                                }}</span
                                            >
                                        </q-item-label>
                                        <q-item-label
                                            :class="!m.read ? 'text-bold' : ''"
                                            >{{
                                                m.from.full_name
                                            }}</q-item-label
                                        >
                                        <q-item-label>{{
                                            m.title
                                        }}</q-item-label>
                                        <q-item-label lines="2"
                                            ><span v-html="m.msg"></span
                                        ></q-item-label>
                                    </q-item-section>
                                    <q-item-section class="text-center" side>
                                        <q-item-label
                                            style="
                                                position: absolute;
                                                top: 10px;
                                            "
                                            v-if="m.interactions?.length > 0"
                                            >{{
                                                m.interactions.length
                                            }}</q-item-label
                                        >
                                        <q-item-label
                                            style="
                                                position: absolute;
                                                bottom: 5px;
                                                right: 40px;
                                            "
                                            @click="
                                                router.post(
                                                    `/admin/private-message/highlight/${m.id}`
                                                )
                                            "
                                            ><q-icon
                                                :name="
                                                    m.highlight
                                                        ? 'star'
                                                        : 'star_border'
                                                "
                                                color="primary"
                                                style="cursor: pointer"
                                            >
                                                <q-tooltip-component
                                                    :title="
                                                        m.highlight
                                                            ? 'dejar de destacar'
                                                            : 'destacar'
                                                    " /></q-icon
                                        ></q-item-label>
                                    </q-item-section>
                                    <q-item-section side>
                                        <btn-left-right-component
                                            title="historico"
                                            :leftDirection="false"
                                            @click="
                                                currentMsg !== m
                                                    ? (currentMsg = m)
                                                    : (currentMsg = null)
                                            "
                                        />
                                    </q-item-section>
                                </q-item>
                            </q-list>
                            <q-item-label class="q-pa-sm" v-else>
                                usted no tiene mensajes privados
                            </q-item-label>
                        </q-card-section>
                        <q-card-actions>
                            <new-private-msg-component
                                @hide="currentMsg = null"
                            />
                        </q-card-actions>
                    </q-card>
                </q-menu>
                <q-badge color="danger" floating v-if="unread > 0">{{
                    unread
                }}</q-badge>
            </btn-private-msg-component>
        </template>
        <template #append>
            <q-icon name="search" />
        </template>
    </q-input>
    <q-dialog v-model="showDialog" persistent :full-hight="fullHeight">
        <q-card>
            <dialog-header-component
                :icon="`img:${$page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-private-msg.png`"
                title="mensajes privados"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-list v-if="messages.length > 0">
                    <q-item
                        v-for="(m, indexMsg) in messages"
                        :key="`msg_${indexMsg}`"
                        style="border-top: 1px solid lightgray"
                    >
                        <q-item-section>
                            <q-item-label
                                ><q-icon
                                    name="circle"
                                    size="15px"
                                    :class="!m.read ? 'text-danger' : ''"
                                >
                                </q-icon>
                                <span :class="!m.read ? 'text-danger' : ''">{{
                                    getFormatDate(m.created_at)
                                }}</span>
                            </q-item-label>
                            <q-item-label :class="!m.read ? 'text-bold' : ''">{{
                                m.from.full_name
                            }}</q-item-label>
                            <q-item-label>{{ m.title }}</q-item-label>
                            <q-item-label
                                lines="1"
                                v-html="m.msg"
                            ></q-item-label>
                        </q-item-section>
                        <q-item-section class="text-center" side>
                            <q-item-label
                                style="position: absolute; top: 10px"
                                v-if="m.interactions?.length > 0"
                                >{{ m.interactions.length }}</q-item-label
                            >
                            <q-item-label
                                style="
                                    position: absolute;
                                    bottom: 5px;
                                    right: 40px;
                                "
                                ><q-icon
                                    name="star_border"
                                    color="primary"
                                    style="cursor: pointer"
                                    @click="highlight(m.id, false)"
                                    v-if="m.highlight"
                                >
                                    <q-tooltip
                                        class="text-body2"
                                        anchor="top middle"
                                        self="bottom middle"
                                        :offset="[5, 5]"
                                        >dejar de destacar</q-tooltip
                                    ></q-icon
                                ><q-icon
                                    name="star_border"
                                    style="cursor: pointer"
                                    @click="highlight(m.id, true)"
                                    v-else
                                >
                                    <q-tooltip
                                        class="text-body2"
                                        anchor="top middle"
                                        self="bottom middle"
                                        :offset="[5, 5]"
                                        >destacar</q-tooltip
                                    ></q-icon
                                ></q-item-label
                            >
                        </q-item-section>
                        <q-item-section side>
                            <q-btn-component
                                tooltips="historico"
                                icon="la la-angle-double-right"
                                class="red-color-on-hover"
                                size="10px"
                                @click="
                                    currentMsg !== m
                                        ? (currentMsg = m)
                                        : (currentMsg = null)
                                "
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
                <p v-else>ud no tiene mensajes privados</p>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-menu
        target="#btn-close-dialog"
        v-model="showHistoryMenu"
        :offset="[-45, -39]"
        persistent
        @hide="currentMsg = null"
        style="width: 350px"
        v-if="currentMsg"
    >
        <q-card>
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-list>
                    <q-item style="border-bottom: 1px solid lightgray">
                        <q-item-section>
                            <q-item-label
                                class="text-center"
                                style="
                                    width: 100%;
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                "
                            >
                                {{ firstMsg.title }}</q-item-label
                            >
                        </q-item-section>
                    </q-item>
                    <q-item style="min-height: 10px">
                        <q-item-section>
                            <q-item-label caption class="text-right">
                                <i class="mdi mdi-calendar-clock-outline"></i>
                                {{ getFormatDate(firstMsg.created_at) }}
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section avatar>
                            <q-avatar
                                font-size="32px"
                                icon="mdi-account-circle"
                            ></q-avatar>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>
                                de:
                                {{ firstMsg.from.full_name }}
                            </q-item-label>
                            <q-item-label
                                >a:
                                <span
                                    v-if="firstMsg.from.id === firstMsg.to.id"
                                >
                                    {{
                                        currentMsg.interactions[0].from
                                            .full_name
                                    }}
                                </span>
                                <span v-else>{{ firstMsg.to.full_name }}</span>
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item
                        style="
                            min-height: 20px;
                            padding-top: 0;
                            padding-bottom: 0;
                        "
                    >
                        <q-item-section>
                            <q-item-label v-html="firstMsg.msg"> </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item
                        v-for="a in firstMsg.attachments"
                        :key="`attachment-${a.id}`"
                        style="
                            min-height: 20px;
                            padding-top: 0;
                            padding-bottom: 0;
                        "
                    >
                        <q-item-section>
                            <q-item-label
                                caption
                                style="font-size: 14px"
                                lines="1"
                                >{{ a.name }}
                                <q-tooltip
                                    class="text-body2"
                                    anchor="top middle"
                                    self="bottom middle"
                                    :offset="[5, 5]"
                                    >{{ a.name }}</q-tooltip
                                >
                            </q-item-label>
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-right: 0"
                        >
                            <btn-show-hide-component
                                :href="`${$page.props.public_path}storage/${a.path}`"
                                target="_blanck"
                                size="sm"
                                tooltips="ver"
                            />
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-left: 0"
                        >
                            <btn-download-component
                                :href="`/admin/private-message/download/${a.id}/`"
                                target="_self"
                                size="xs"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
                <q-list
                    v-for="(child, indexMsgChild) in currentMsg.interactions"
                    :key="`msg_child_${indexMsgChild}`"
                >
                    <q-item
                        style="
                            min-height: 10px;
                            border-top: 1px solid lightgray;
                        "
                    >
                        <q-item-section>
                            <q-item-label caption class="text-right">
                                <i class="mdi mdi-calendar-clock-outline"></i>
                                {{ getFormatDate(child.created_at) }}
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section avatar>
                            <q-avatar
                                font-size="32px"
                                icon="mdi-account-circle"
                            ></q-avatar>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>
                                de:
                                {{ child.from.full_name }}
                            </q-item-label>
                            <q-item-label
                                >a: {{ child.to.full_name }}
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item
                        style="
                            min-height: 20px;
                            padding-top: 0;
                            padding-bottom: 0;
                        "
                    >
                        <q-item-section>
                            <q-item-label v-html="child.msg"> </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item
                        v-for="a in child.attachments"
                        :key="`attachment-${a.id}`"
                        style="
                            min-height: 20px;
                            padding-top: 0;
                            padding-bottom: 0;
                        "
                    >
                        <q-item-section>
                            <q-item-label
                                caption
                                style="font-size: 14px"
                                lines="1"
                                >{{ a.name }}
                                <q-tooltip
                                    class="text-body2"
                                    anchor="top middle"
                                    self="bottom middle"
                                    :offset="[5, 5]"
                                    >{{ a.name }}</q-tooltip
                                >
                            </q-item-label>
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-right: 0"
                        >
                            <btn-show-hide-component
                                :href="`${$page.props.public_path}storage/${a.path}`"
                                target="_blanck"
                                size="sm"
                                tooltips="ver"
                            />
                        </q-item-section>
                        <q-item-section
                            avatar
                            style="min-width: 20px; padding-left: 0"
                        >
                            <btn-download-component
                                :href="`/admin/private-message/download/${a.id}/`"
                                size="xs"
                                target="_self"
                            />
                        </q-item-section>
                    </q-item> </q-list
            ></q-card-section>
            <q-card-actions>
                <new-private-msg-component
                    :user="currentMsg.from_id"
                    :parent="
                        currentMsg.parent_id
                            ? currentMsg.parent_id
                            : currentMsg.id
                    "
                    :title="currentMsg.title"
                    :show-list-user="false"
                />
            </q-card-actions>
        </q-card>
    </q-menu>
</template>

<script setup>
defineOptions({
    name: "MgrPrivateMsgComponent",
});

import { ref, watch, computed, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../btn/BtnLeftRightComponent.vue";
import BtnPrivateMsgComponent from "../../btn/BtnPrivateMsgComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnShowHideComponent from "../../btn/BtnShowHideComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import NewPrivateMsgComponent from "./NewPrivateMsgComponent.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { Dark, date } from "quasar";
import { error } from "../../../helpers/notifications";
import axios from "axios";

const props = defineProps({
    size: {
        type: String,
        default: "xs",
    },
    object: {
        type: Object,
        default: null,
    },
    fieldToStr: {
        type: String,
        default: "id",
    },
    title: {
        type: String,
        default: "Object",
    },
    fullHeight: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["save"]);
const msgMenu = ref(null);
const showDialog = ref(false);
const showHistoryMenu = ref(false);
const currentMsg = ref(null);
const firstMsg = ref(null);
const unread = ref(0);
const page = usePage();
const form = useForm({
    poster: null,
});
const messages = ref([]);

onMounted(() => {
    messages.value = page.props.private_messages;
    countUnread();
});

watch(
    () => page.props.private_messages,
    (n) => {
        messages.value = n;
        countUnread();
    }
);

const countUnread = () => {
    unread.value = 0;
    messages.value.forEach((m) => {
        if (!m.read) {
            unread.value++;
        }
    });
};

watch(currentMsg, () => {
    showHistoryMenu.value = currentMsg.value !== null;
    firstMsg.value =
        currentMsg.value !== null
            ? currentMsg.value.parent !== null
                ? currentMsg.value.parent
                : currentMsg.value
            : null;
    setRead();
});

watch(
    messages,
    (m) => {
        if (currentMsg.value) {
            let msg = m.find((mm) => mm.id === currentMsg.value.id);
            if (msg) {
                currentMsg.value.interactions = msg.interactions;
            }
        }
    },
    {
        deep: true,
    }
);

const getFormatDate = (d) => {
    return date.formatDate(d, "DD MMM YYYY hh:mm:ss A");
};

const setRead = async () => {
    if (currentMsg.value !== null && !currentMsg.value.read) {
        await axios
            .put(`/admin/private-message/read/${currentMsg.value.id}`)
            .then((response) => {
                unread.value--;
                currentMsg.value.read = true;
            })
            .catch((error) => {
                error("ha ocurrido un error al tratar de ver el mensaje");
            });
    }
};

const save = async () => {
    form.post(`/admin/files/poster/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};
</script>
