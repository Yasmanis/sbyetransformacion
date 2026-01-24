<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="
            reads.length > 0
                ? notifications.filter((n) => reads.includes(n.read))
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
        <template v-slot:body-cell-description="props">
            <q-td :class="props.row.id === highlightedId ? 'text-bold' : null">
                <span v-html="props.row.description" class="no-padding"></span>
            </q-td>
        </template>
        <template v-slot:body-cell-read="props">
            <q-td>
                <q-chip
                    dense
                    size="sm"
                    style="max-width: min-content"
                    :color="props.value ? 'black' : 'blue-2'"
                    :text-color="props.value ? 'white' : 'black'"
                    :icon="props.value ? 'check' : 'error'"
                    :label="props.value ? 'Si' : 'No'"
                />
            </q-td>
        </template>
        <template v-slot:body-cell-actions="props">
            <q-td style="width: 120px">
                <form-reply-component
                    :object="
                        props.row.code === 'help_from_contact'
                            ? props.row
                            : null
                    "
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
            </q-td>
        </template>
    </q-table>

    <confirm-component
        :show="confirm"
        @hide="confirm = false"
        @ok="
            router.delete(`/auth/delete-notification/${noti_id}`, {
                onSuccess: () => {
                    confirm = false;
                },
            })
        "
    />
</template>

<script setup>
import { computed, onBeforeMount, onMounted, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import DeleteComponent from "../table/actions/DeleteComponent.vue";
import BtnClearComponent from "../btn/BtnClearComponent.vue";
import FormReplyComponent from "./FormReplyComponent.vue";
import FilterComponent from "../table/actions/FilterComponent.vue";

defineOptions({
    name: "NotificationsManagerComponent",
});

const props = defineProps({
    notificationFromEmail: Object,
});
const confirm = ref(false);
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
        field: "description",
        name: "description",
        label: "mensaje",
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
            id = hash.id;
        if (model && id) {
            const foundRecord = notifications.value.find(
                (record) => record.model === model && record.model_id === id,
            );
            if (foundRecord) {
                const rowsPerPage = pagination.value.rowsPerPage;
                const recordIndex = notifications.value.findIndex(
                    (record) =>
                        record.model === model && record.model_id === id,
                );
                const targetPage = Math.floor(recordIndex / rowsPerPage) + 1;
                pagination.value.page = targetPage;
                highlightedId.value = foundRecord.id;
            }
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
        });
    });
    return notifications;
});

const onClear = () => {
    highlightedId.value = null;
    window.location.hash = "";
    reads.value = [true, false];
};
</script>
<style>
span.no-padding p {
    margin: 0px !important;
}
</style>
