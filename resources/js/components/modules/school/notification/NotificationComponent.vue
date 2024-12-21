<template>
    <btn-notification-component @click="showDialog = true" />
    <q-dialog v-model="showDialog" persistent full-width>
        <q-card>
            <dialog-header-component
                :icon="`img:${$page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-notification.png`"
                title="gestion de avisos"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-tabs
                    v-model="tab"
                    dense
                    active-color="primary"
                    indicator-color="primary"
                    align="left"
                >
                    <q-tab name="all" label="todos"/>
                    <q-tab name="active" label="activos" />
                    <q-tab name="caduced" label="caducados" />
                    <q-tab name="archived" label="archivados" />
                </q-tabs>

                <q-separator />

                <q-table :columns="columns" :rows="rows" row-key="id" dense />

            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Dark } from "quasar";
import BtnNotificationComponent from "../../../btn/BtnNotificationComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";

defineOptions({
    name: "NotificationComponent",
});

const props = defineProps({
    video: Object,
    show: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);
const tab = ref('all');

const columns = ref([
    { name: "date", label: "fecha", field: "date", sortable: true, align:'left' },
    { name: "message", label: "aviso", field: "message", sortable: true, align:'left' },
    { name: "expired", label: "caducidad", field: "expired", sortable: true, align:'left' },
]);

const rows = ref([]);

for (let i = 0; i < 100; i++){
    rows.value.push({
        date: `date ${i}`,
        message: `este es un mensaje de prueba para ver como se ve la tabla`,
        expired: `${i%2===0?'caducado':''}`
    })
}
</script>
