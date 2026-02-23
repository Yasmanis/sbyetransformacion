<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="
            noti_id
                ? filteredById()
                : reads.length > 0
                  ? filteredByReads()
                  : notifications
        "
        wrap-cells
        flat
        class="no-padding"
        selection="multiple"
        color="primary"
        v-model:selected="selected"
        v-model:pagination="pagination"
        :rows-per-page-options="[10, 20, 30, 50, 100]"
    >
        <template v-slot:top>
            <q-toolbar dense>
                <div class="col col-auto q-gutter-sm">
                    <q-btn
                        no-caps
                        color="black"
                        label="mostrar todas las notificaciones"
                        @click="onClear"
                        v-if="noti_id && notifications.length > 1"
                    ></q-btn>
                    <q-option-group
                        name="accepted_genres"
                        v-model="reads"
                        :options="[
                            { label: 'leidas', value: true },
                            { label: 'sin leer', value: false },
                        ]"
                        type="checkbox"
                        color="primary"
                        inline
                        v-else
                    />
                </div>
                <q-space />
                <div class="col-auto q-gutter-sm">
                    <btn-clear-component
                        tooltips="quitar filtro/resaltado"
                        @click="onClear"
                        v-if="highlightedId || reads.length === 1"
                    />
                    <btn-show-hide-component
                        titlePublic="marcar todas las notificaciones como leida"
                        :public="false"
                        @click="
                            router.post(`/auth/mark-notifications-as/`, {
                                read: true,
                            })
                        "
                    />
                    <btn-show-hide-component
                        titleHide="marcar todas las notificaciones como no leida"
                        :public="true"
                        @click="
                            router.post(`/auth/mark-notifications-as/`, {
                                read: false,
                            })
                        "
                    />
                    <delete-component
                        :objects="selected"
                        url="/auth/delete-notification"
                        @deleted="selected = []"
                        v-if="selected.length"
                    />
                </div>
            </q-toolbar>
        </template>
        <template v-slot:header="props">
            <q-tr :props="props">
                <q-th auto-width>
                    <q-checkbox dense v-model="props.selected" />
                </q-th>
                <q-th v-for="col in props.cols" :key="col.name" :props="props">
                    {{ col.label }}
                </q-th>
            </q-tr>
        </template>
        <template v-slot:body="props">
            <q-tr :props="props">
                <q-td auto-width>
                    <q-checkbox dense v-model="props.selected" />
                </q-td>
                <q-td v-for="col in props.cols" :key="col.name" :props="props">
                    <template v-if="col.name === 'title'">
                        <span v-if="props.row.code === 'reply_contact'"
                            >{{
                                props.row.title.substring(
                                    0,
                                    props.row.title.indexOf('"'),
                                )
                            }}
                            <span
                                class="cursor-pointer text-primary"
                                @click="
                                    router.visit(
                                        `/auth/profile#${getStr(props.row)}`,
                                    )
                                "
                            >
                                {{
                                    props.row.title.substring(
                                        props.row.title.indexOf('"'),
                                    )
                                }}
                                <q-tooltip> click para ir al tiket </q-tooltip>
                            </span> </span
                        ><span v-else-if="props.row.code === 'chat_writter'"
                            >{{ props.row.title }}
                            <q-btn
                                dense
                                size="xs"
                                icon="mdi-arrow-right-top"
                                color="black"
                                :href="`/admin/${props.row.chat}`"
                            >
                                <q-tooltip> click para ir al chat </q-tooltip>
                            </q-btn>
                        </span>
                        <span v-else>
                            {{ props.row.title }}
                        </span>
                    </template>

                    <q-chip
                        dense
                        size="sm"
                        style="max-width: min-content"
                        :color="props.value ? 'black' : 'blue-2'"
                        :text-color="props.value ? 'white' : 'black'"
                        :icon="props.value ? 'check' : 'error'"
                        :label="props.value ? 'Si' : 'No'"
                        v-else-if="col.name === 'read'"
                    />
                    <template v-else-if="col.name === 'actions'">
                        <form-reply-component
                            :tiket-id="
                                props.row.code === 'help_from_contact'
                                    ? parseInt(props.row.data[0].model_id)
                                    : null
                            "
                            target="notifications"
                        />
                        <btn-show-hide-component
                            titleHide="marcar como no leido"
                            titlePublic="marcar como leido"
                            :public="props.row.read"
                            @click="
                                router.post(
                                    `/auth/read-unread-notification/${props.row.id}`,
                                )
                            "
                        />
                        <delete-component
                            :objects="[props.row]"
                            url="/auth/delete-notification"
                            @deleted="selected = []"
                        />
                    </template>

                    <span v-else>{{ col.value }}</span>
                </q-td>
            </q-tr>
            <q-tr :props="props" v-if="props.row.code !== 'reply_contact'">
                <q-td colspan="100%">
                    <q-list style="padding-left: 35px; padding-right: 10px">
                        <q-item class="q-my-xs">
                            <q-item-section avatar>
                                <q-icon name="mdi-email-outline"> </q-icon>
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>
                                    <span
                                        v-html="props.row.description"
                                        class="no-padding"
                                    ></span>
                                </q-item-label>
                            </q-item-section>
                        </q-item>
                        <attachments-component
                            :attachments="props.row.attachments"
                            base-url="/admin/tikets/download-attachment"
                        />
                    </q-list>
                    <div
                        class="row justify-center"
                        style="padding-left: 45px; padding-right: 30px"
                        v-if="props.row.responses.length > 0"
                    >
                        <div style="width: 100%">
                            <chat-message-component
                                :messages="props.row.responses"
                                target="notifications"
                            />
                        </div>
                    </div>
                </q-td>
            </q-tr>
        </template>
    </q-table>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import DeleteComponent from "../table/actions/DeleteComponent.vue";
import BtnClearComponent from "../btn/BtnClearComponent.vue";
import FormReplyComponent from "./FormReplyComponent.vue";
import AttachmentsComponent from "../others/AttachmentsComponent.vue";
import ChatMessageComponent from "../others/ChatMessageComponent.vue";

defineOptions({
    name: "NotificationsManagerComponent",
});

const props = defineProps({
    notificationFromEmail: Object,
});

const noti_id = ref(null);
const selected = ref([]);
const highlightedId = ref(false);
const page = usePage();
const reads = ref([true, false]);

const pagination = ref({
    page: 1,
    rowsPerPage: 10,
});

const columns = ref([
    {
        field: "title",
        name: "title",
        label: "titulo",
        align: "left",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
    {
        field: "priority",
        name: "priority",
        label: "prioridad",
        align: "left",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
    {
        field: "time",
        name: "time",
        label: "desde",
        align: "left",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
    {
        field: "user",
        name: "user",
        label: "usuario",
        align: "left",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
    {
        field: "read",
        name: "read",
        label: "leida",
        align: "left",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
    {
        field: "actions",
        name: "actions",
        label: "",
        align: "center",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
]);

onMounted(() => {
    let hash = window.location.hash;
    if (hash && hash.trim() !== "") {
        hash = JSON.parse(atob(hash.substring(1)));
        let model = hash.model,
            id = hash.id,
            uniqueId = hash.filters?.uniqueId ?? null;
        let foundRecord;
        if (uniqueId) {
            foundRecord = notifications.value.find(
                (record) => record.id === uniqueId,
            );
        } else if (model && id) {
            foundRecord = notifications.value.find(
                (record) => record.model === model && record.model_id === id,
            );
        }
        if (foundRecord) {
            noti_id.value = foundRecord.id;
        } else if (hash.filters?.reads) {
            reads.value = hash.filters?.reads;
        }
    }
});

const notifications = computed(() => {
    let notifications = [];
    page.props.auth.user.notifications.forEach((n) => {
        const { title, priority, description, model, model_id, code } =
            n.data[0];
        notifications.push({
            id: n.id,
            type: n.type,
            title,
            priority,
            code,
            description,
            model,
            model_id,
            time: n.time,
            user: n.user,
            read: n.read_at !== null,
            attachments: n.attachments,
            responses: n.responses,
            data: n.data,
            chat: n.chat,
        });
    });
    return notifications;
});

const filteredById = () => {
    return notifications.value.filter((n) => n.id === noti_id.value);
};

const filteredByReads = () => {
    return notifications.value.filter((n) => reads.value.includes(n.read));
};

const onClear = () => {
    highlightedId.value = null;
    noti_id.value = null;
    window.location.hash = "";
    reads.value = [true, false];
};

const getStr = (n) => {
    let data = n.data[0],
        tab = "notifications";
    let { id, target, code, row_id } = data;
    if (code === "reply_contact") {
        if (row_id) {
            id = row_id;
            tab = target;
        }
    }
    return btoa(
        JSON.stringify({
            tab: tab,
            filters: {
                uniqueId: id,
            },
        }),
    );
};
</script>
<style>
span.no-padding p {
    margin: 0px !important;
}
</style>
