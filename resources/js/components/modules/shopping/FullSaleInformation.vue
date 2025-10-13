<template>
    <q-btn-component
        label="toda mi informacion"
        class="full-width"
        :flat="false"
        :round="false"
        square
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 900px; max-width: 100vw">
            <dialog-header-component
                icon="mdi-cart-variant"
                title="informacion detallada sobre la compra"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div class="col text-h6 text-bold">JUNT@S!</div>
                    <div class="col text-center">
                        <div class="q-gutter-sm">
                            <btn-basket-component />
                            <btn-return-sale-component />
                        </div>
                    </div>
                    <div class="col text-right">
                        <div class="q-gutter-sm">
                            <btn-notification-component
                                tooltips="avisos"
                                :badge="5"
                            />
                            <btn-edit-component />
                        </div>
                    </div>
                </div>
                <q-list dense>
                    <q-item style="padding: 0">
                        <q-item-section avatar top>
                            <q-img
                                :src="`${$page.props.public_path}images/logo/2.png`"
                                fit
                                :ratio="16 / 9"
                                width="160px"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label class="text-bold">
                                JUNT@S!
                            </q-item-label>
                            <q-item-label>contado</q-item-label>
                            <q-item-label
                                ><ul class="q-ma-none q-pl-md text-body2">
                                    <li>pago inicial 270 €</li>
                                    <li>4 pagos mensuales de 130 €</li>
                                </ul></q-item-label
                            >
                        </q-item-section>
                        <q-item-section avatar top>
                            <q-item-label> fecha pedido </q-item-label>
                            <q-item-label class="q-py-xs">
                                fecha entrega
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar top>
                            <q-item-label> 01-08-2023 </q-item-label>
                            <q-item-label
                                class="bg-primary text-white text-right q-pa-xs"
                                style="min-width: 90px"
                            >
                                N/P
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
                <q-item dense style="padding: 0" class="q-mt-md">
                    <q-item-section class="text-primary"
                        >danos tu opinion sobre este producto
                    </q-item-section>
                    <q-item-section>
                        <q-rating
                            color="primary"
                            icon="star_border"
                            icon-selected="star"
                            size="sm"
                        />
                    </q-item-section>
                    <q-item-section avatar class="text-primary"
                        >localiza tu paquete</q-item-section
                    >
                </q-item>
                <q-item dense style="padding: 0" class="q-mt-md">
                    <q-item-section> </q-item-section>
                    <q-item-section avatar class="bg-primary text-white">
                        proximo pago previsto
                    </q-item-section>
                    <q-item-section avatar class="bg-primary text-white"
                        >130 €</q-item-section
                    >
                    <q-item-section avatar class="bg-primary text-white">
                        <q-item-label class="q-mr-md"
                            >01-08-2023</q-item-label
                        ></q-item-section
                    >
                </q-item>
                <div class="row q-mt-sm">
                    <div class="col">
                        <b>tabla de pagos</b>
                        <q-table
                            :columns="columns"
                            :rows="rows"
                            flat
                            dense
                            hide-bottom
                            table-header-class="header-no-bold"
                        >
                            <template v-slot:body-cell-payment_receipt="props">
                                <q-td :props="props" class="text-center">
                                    <btn-warning-component
                                        tooltips="tu pago no se ha podido procesar"
                                        v-if="props.row.date === '01-07-2023'"
                                    />
                                    <btn-download-component
                                        size="sm"
                                        v-else-if="props.row.amount"
                                    />
                                </q-td>
                            </template>
                        </q-table>
                    </div>
                </div>
                <div class="row q-mt-sm">
                    <div class="col text-right">
                        <span class="bg-primary text-white q-pa-xs q-px-md">
                            pendiente de pago: 260 €
                        </span>
                    </div>
                </div>
                <q-list dense>
                    <q-item>
                        <q-item-section avatar
                            ><btn-attachment-component size="12px" />
                        </q-item-section>
                        <q-item-section avatar> contrato </q-item-section>
                        <q-item-section avatar>
                            <btn-download-component size="sm" />
                        </q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section avatar
                            ><btn-attachment-component size="12px" />
                        </q-item-section>
                        <q-item-section avatar> factura </q-item-section>
                        <q-item-section avatar class="text-right">
                            <btn-download-component
                                size="sm"
                                style="margin-left: 10px"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnBasketComponent from "../../btn/BtnBasketComponent.vue";
import BtnReturnSaleComponent from "../../btn/BtnReturnSaleComponent.vue";
import BtnNotificationComponent from "../../btn/BtnNotificationComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import BtnWarningComponent from "../../btn/BtnWarningComponent.vue";
import BtnAttachmentComponent from "../../btn/BtnAttachmentComponent.vue";

defineOptions({
    name: "FullSaleInformation",
});

const props = defineProps({
    object: Object,
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);

const columns = ref([
    {
        name: "date",
        field: "date",
        label: "fecha",
        headerClasses: "bg-primary text-white",
        align: "left",
    },
    {
        name: "summary",
        field: "summary",
        label: "resumen",
        headerClasses: "bg-primary text-white",
        align: "left",
    },
    {
        name: "cost",
        field: "cost",
        label: "importe",
        headerClasses: "bg-primary text-white",
        align: "right",
    },
    {
        name: "amount",
        field: "amount",
        label: "pagado a la fecha",
        headerClasses: "bg-primary text-white text-body1",
        align: "right",
    },
    {
        name: "payment_receipt",
        field: "payment_receipt",
        label: "recibo de pago",
        headerClasses: "bg-primary text-white text-body1",
        align: "center",
    },
]);

const rows = ref([
    {
        date: "01-05-2023",
        summary: "primer pago con la compra",
        cost: "270 €",
        amount: "270 €",
    },
    {
        date: "01-06-2023",
        summary: "segundo pago",
        cost: "130 €",
        amount: "400 €",
    },
    {
        date: "01-07-2023",
        summary: "tercer pago",
        cost: "130 €",
        amount: "530 €",
    },
    {
        date: "01-08-2023",
        summary: "cuarto pago",
        cost: "130 €",
    },
    {
        date: "01-09-2023",
        summary: "quinto pago",
        cost: "130 €",
    },
]);
</script>
