<template>
    <q-table
        row-key="id"
        :columns="columns"
        :rows="objectId ? filteredById() : rows"
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
                <div class="col col-auto q-gutter-sm q-mr-md">
                    <q-btn
                        no-caps
                        color="black"
                        label="mostrar todos los tikets"
                        @click="onClear"
                        v-if="objectId && rows.length > 1"
                    ></q-btn>
                </div>
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
                    <q-chip
                        dense
                        size="sm"
                        style="max-width: min-content"
                        :color="props.value ? 'black' : 'blue-2'"
                        :text-color="props.value ? 'white' : 'black'"
                        :icon="props.value ? 'check' : 'error'"
                        :label="props.value ? 'Si' : 'No'"
                        v-if="col.name === 'read'"
                    />
                    <template v-else-if="col.name === 'actions'">
                        <btn-show-hide-component
                            :public="props.expand"
                            :disable="props.row.responses.length === 0"
                            title-public="ver respuesta"
                            title-hide="ocultar respuesta"
                            @click="props.expand = !props.expand"
                        />
                        <delete-component
                            :objects="[props.row]"
                            :cancel="true"
                            message="al eliminar este tiket no podra recibir mas respuestas sobre el mismo, confirma su eliminacion"
                            url="/admin/tikets"
                            @deleted="selected = []"
                        />
                    </template>
                    <span v-else>{{ col.value }}</span>
                </q-td>
            </q-tr>
            <q-tr :props="props">
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
                                :from-parent="true"
                                :has-reply="true"
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
import DeleteComponent from "../table/actions/DeleteComponent.vue";
import BtnReloadComponent from "../btn/BtnReloadComponent.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import AttachmentsComponent from "../others/AttachmentsComponent.vue";
import ChatMessageComponent from "../others/ChatMessageComponent.vue";
import FormReplyComponent from "./FormReplyComponent.vue";
import { date } from "quasar";
import { router, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "TiketsComponent",
});

const props = defineProps({
    notificationFromEmail: Object,
});

const page = usePage();
const loading = ref(false);
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
        field: "created_at",
        name: "created_at",
        label: "fecha",
        align: "left",
        style: "width: 220px",
        format: (val) => {
            return date.formatDate(val, "DD/MM/YYYY hh:mm a");
        },
    },
    {
        field: "actions",
        name: "actions",
        label: "",
        align: "center",
        style: "width: 150px",
        classes: (row) => {
            return row.id === highlightedId.value ? "text-bold" : null;
        },
    },
]);
const objectId = ref(null);

onMounted(() => {
    let hash = window.location.hash;
    if (hash && hash.trim() !== "") {
        hash = JSON.parse(atob(hash.substring(1)));
        let uniqueId = hash.filters?.uniqueId ?? null;
        let foundRecord;
        if (uniqueId) {
            console.log(uniqueId, rows.value);

            foundRecord = rows.value.find((record) => record.id === uniqueId);
            console.log(foundRecord);

            if (foundRecord) {
                objectId.value = foundRecord.id;
            }
        }
    }
    console.log(rows.value);
});

const rows = computed(() => {
    return page.props.tikets;
});

const filteredById = () => {
    return rows.value.filter((n) => n.id === objectId.value);
};

const onClear = () => {
    objectId.value = null;
    window.location.hash = "";
};
</script>
<style>
span.no-padding p {
    margin: 0px !important;
}
</style>
