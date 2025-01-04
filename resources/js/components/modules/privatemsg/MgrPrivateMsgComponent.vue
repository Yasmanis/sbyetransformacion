<template>
    <q-input dense outlined>
        <template #before>
            <btn-private-msg-component>
                <q-menu ref="msgMenu">
                    <q-card class="q-pa-sm">
                        <q-card-section>
                            <q-btn
                                icon="close"
                                flat
                                dense
                                class="absolute-top-right"
                                @click="msgMenu.hide()"
                            />
                            <q-item-label class="q-pa-sm text-center"
                                >mensajes privados</q-item-label
                            >
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <span v-if="messages.length > 0"></span>
                            <q-item-label class="q-pa-sm" v-else>
                                usted no tiene mensajes privados
                            </q-item-label>
                        </q-card-section>
                        <q-card-actions>
                            <new-private-msg-component />
                        </q-card-actions>
                    </q-card>
                </q-menu>
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
            />
            <q-card-section class="col q-pt-none"> </q-card-section>
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
        :offset="[-45, -47]"
        persistent
        v-if="currentMsg"
    >
        <q-card style="width: 350px">
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
                <q-item style="min-height: 10px; padding: 2px 2px">
                    <q-item-section>
                        <q-item-label caption class="text-right">
                            <i class="la la-calendar"></i>
                            {{ firstMsg.created_at }}
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
                            <span v-if="firstMsg.from.id === firstMsg.to.id">
                                {{ currentMsg.interactions[0].from.full_name }}
                            </span>
                            <span v-else>{{ firstMsg.to.full_name }}</span>
                        </q-item-label>
                    </q-item-section>
                </q-item>
                <q-item
                    style="min-height: 20px; padding-top: 0; padding-bottom: 0"
                >
                    <q-item-section>
                        <q-item-label v-html="firstMsg.msg"> </q-item-label>
                    </q-item-section>
                </q-item>
                <q-item
                    v-for="a in firstMsg.attachments"
                    :key="`attachment-${a.id}`"
                    style="min-height: 20px; padding-top: 0; padding-bottom: 0"
                >
                    <q-item-section>
                        <q-item-label caption style="font-size: 14px" lines="1"
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
                            :href="`${url}/storage/${a.path}`"
                            target="_blanck"
                            tooltips="ver"
                        />
                    </q-item-section>
                    <q-item-section
                        avatar
                        style="min-width: 20px; padding-left: 0"
                    >
                        <btn-download-component
                            :href="`${url}/${base}/download/${a.id}/`"
                            target="_self"
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
                        padding: 2px 2px;
                        border-top: 1px solid lightgray;
                    "
                >
                    <q-item-section>
                        <q-item-label caption class="text-right">
                            <i class="la la-calendar"></i>
                            {{ child.created_at }}
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
                    style="min-height: 20px; padding-top: 0; padding-bottom: 0"
                >
                    <q-item-section>
                        <q-item-label v-html="child.msg"> </q-item-label>
                    </q-item-section>
                </q-item>
                <q-item
                    v-for="a in child.attachments"
                    :key="`attachment-${a.id}`"
                    style="min-height: 20px; padding-top: 0; padding-bottom: 0"
                >
                    <q-item-section>
                        <q-item-label caption style="font-size: 14px" lines="1"
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
                            :href="`${url}/storage/${a.path}`"
                            target="_blanck"
                            tooltips="ver"
                        />
                    </q-item-section>
                    <q-item-section
                        avatar
                        style="min-width: 20px; padding-left: 0"
                    >
                        <btn-download-component
                            :href="`${url}/${base}/download/${a.id}/`"
                            target="_self"
                        />
                    </q-item-section>
                </q-item>
            </q-list>
            <q-list>
                <q-item>
                    <new-private-msg-component
                        :user="currentMsg.from_id"
                        :parent="
                            currentMsg.parent_id
                                ? currentMsg.parent_id
                                : currentMsg.id
                        "
                        :title="currentMsg.title"
                        @save="onSaveMessage"
                    />
                </q-item>
            </q-list>
        </q-card>
    </q-menu>
</template>

<script setup>
defineOptions({
    name: "MgrPrivateMsgComponent",
});

import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnPrivateMsgComponent from "../../btn/BtnPrivateMsgComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnShowHideComponent from "../../btn/BtnShowHideComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import NewPrivateMsgComponent from "./NewPrivateMsgComponent.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { Dark } from "quasar";

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
const currentMsg = ref(null);
const messages = ref([]);

const form = useForm({
    poster: null,
});

const save = async () => {
    form.post(`/admin/files/poster/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};
</script>
