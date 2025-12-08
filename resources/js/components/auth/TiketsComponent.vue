<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="rows"
        :loading="loading"
        :filter="filter"
        wrap-cells
        flat
        class="no-padding"
        selection="multiple"
        v-model:selected="selected"
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
                    <btn-reload-component @click="load" />
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
            <q-td style="width: 100px">
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
import { onMounted, ref } from "vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import DeleteComponent from "../table/actions/DeleteComponent.vue";
import BtnReloadComponent from "../btn/BtnReloadComponent.vue";
import { date } from "quasar";
import axios from "axios";

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
            console.log(val);

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

const rows = ref([]);

onMounted(() => {
    load();
});

const load = async () => {
    loading.value = true;
    axios
        .get("/admin/tikets")
        .then((result) => {
            rows.value = result.data;
        })
        .finally(() => {
            loading.value = false;
        });
};
</script>
<style>
span.no-padding p {
    margin: 0px !important;
}
</style>
