<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="notifications"
        wrap-cells
        flat
        class="no-padding"
        selection="multiple"
        v-model:selected="selected"
        hide-pagination
    >
        <template v-slot:top="props" class="no-padding">
            <q-toolbar dense>
                <q-space />
                <div class="col-auto q-gutter-sm">
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
            <!-- <div
                    class="row"
                    style="
                        width: 100%;
                        border-top: 1px solid rgba(0, 0, 0, 0.12);
                        padding: 10px;
                    "
                    v-if="searchFields.length > 0 || filterFields.length > 0"
                >
                    <div class="col" v-if="searchFields.length > 0">
                        <search-component
                            :fields="searchFields"
                            @refresh-data="onRefreshData"
                        ></search-component>
                    </div>
                </div> -->
        </template>
        <template v-slot:body-cell-description="props">
            <q-td>
                <span v-html="props.row.description"></span>
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
            <q-td style="width: 100px">
                <btn-show-hide-component
                    titleHide="marcar como no leido"
                    titlePublic="marcar como leido"
                    :public="props.row.read"
                    @click="
                        router.post(
                            `/auth/read-unread-notification/${props.row.id}`
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
import { computed, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import SearchComponent from "../table/actions/SearchComponent.vue";
import FilterComponent from "../table/actions/FilterComponent.vue";
import DeleteComponent from "../table/actions/DeleteComponent.vue";

defineOptions({
    name: "NotificationsManagerComponent",
});

const confirm = ref(false);
const noti_id = ref(null);
const selected = ref([]);

const notifications = computed(() => {
    let notifications = [];
    usePage().props.auth.user.notifications.forEach((n) => {
        notifications.push({
            id: n.id,
            type: n.type,
            title: n.data[0].title,
            priority: n.data[0].priority,
            description: n.data[0].description,
            time: n.time,
            user: n.user,
            read: n.read_at !== null,
        });
    });
    return notifications;
});

const columns = ref([
    {
        field: "title",
        name: "title",
        label: "titulo",
        align: "left",
    },
    {
        field: "priority",
        name: "priority",
        label: "prioridad",
        align: "left",
    },
    {
        field: "description",
        name: "description",
        label: "mensaje",
        align: "left",
    },
    {
        field: "time",
        name: "time",
        label: "desde",
        align: "left",
    },
    {
        field: "user",
        name: "user",
        label: "usuario",
        align: "left",
    },
    {
        field: "read",
        name: "read",
        label: "leida",
        align: "left",
    },
    {
        field: "actions",
        name: "actions",
        label: "",
        align: "center",
    },
]);
</script>
