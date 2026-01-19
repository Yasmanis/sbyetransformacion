<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="$page.props.tikets"
        :loading="loading"
        :filter="filter"
        wrap-cells
        flat
        class="no-padding"
        selection="multiple"
        v-model:selected="selected"
        color="primary"
        :rows-per-page-options="[10, 20, 30, 50, 100]"
    >
        <template v-slot:top>
            <q-toolbar dense>
                <div class="col-auto q-gutter-sm">
                    <q-input
                        dense
                        debounce="300"
                        v-model="filter"
                        clearable
                        placeholder="buscar"
                    >
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </div>
                <q-space />
                <div class="col-auto q-gutter-sm q-mr-md">
                    <btn-reload-component @click="router.reload()" />
                    <delete-component
                        :objects="selected"
                        url="/admin/tikets"
                        @deleted="selected = []"
                        v-if="selected.length > 0"
                    />
                </div>
            </q-toolbar>
        </template>

        <template v-slot:header="props">
            <q-tr :props="props">
                <q-th auto-width />
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
                    <q-btn
                        round
                        dense
                        flat
                        :icon="props.expand ? 'remove' : 'add'"
                        :disable="props.row.tikets.length === 0"
                        @click="props.expand = !props.expand"
                    /> </q-td
                ><q-td auto-width>
                    <q-checkbox dense v-model="props.selected" />
                </q-td>
                <q-td v-for="col in props.cols" :key="col.name" :props="props">
                    <span
                        class="no-padding"
                        v-html="col.value"
                        v-if="col.name === 'description'"
                    >
                    </span>
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
                    <delete-component
                        :objects="[props.row]"
                        url="/admin/tikets"
                        @deleted="selected = []"
                        v-else-if="col.name === 'actions'"
                    />
                    <span v-else>{{ col.value }}</span>
                </q-td>
            </q-tr>
            <q-tr v-show="props.expand" :props="props">
                <q-td colspan="100%">
                    <div class="q-px-md q-gutter-md">
                        <q-list dense>
                            <q-item
                                v-for="t in props.row.tikets"
                                :key="`tiket-${t.id}`"
                            >
                                <q-item-section>
                                    <q-item-label class="text-weight-bold">{{
                                        t.user_str
                                    }}</q-item-label>
                                    <q-item-label caption>
                                        <span v-html="t.message"></span>
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section side top>
                                    {{ t.date_humans }}
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </q-td>
            </q-tr>
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
import { ref } from "vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import DeleteComponent from "../table/actions/DeleteComponent.vue";
import BtnReloadComponent from "../btn/BtnReloadComponent.vue";
import { date } from "quasar";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "TiketsComponent",
});

const props = defineProps({
    notificationFromEmail: Object,
});

const loading = ref(false);
const confirm = ref(false);
const noti_id = ref(null);
const selected = ref([]);
const highlightedId = ref(false);
const filter = ref("");
const columns = ref([
    {
        field: "subject",
        name: "subject",
        label: "titulo",
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
        field: "attachments",
        name: "attachments",
        label: "adjuntos",
        align: "left",
    },
    {
        field: "created_at",
        name: "created_at",
        label: "fecha",
        align: "left",
        style: "width: 200px",
        format: (val) => {
            return date.formatDate(val, "DD/MM/YYYY hh:mm a");
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
</script>
<style>
span.no-padding p {
    margin: 0px !important;
}
</style>
