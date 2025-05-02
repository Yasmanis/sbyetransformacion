<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item>
                            <q-item-section avatar top>
                                <q-img
                                    :src="`${$page.props.public_path}images/logo/2.png`"
                                    fit
                                    width="70px"
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
                                <q-item-label class="text-bold">
                                    790 €
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar top>
                                <q-input dense outlined style="width: 50px" />
                            </q-item-section>
                            <q-item-section
                                avatar
                                top
                                style="padding: 0px; min-width: 20px"
                            >
                                <btn-delete-component class="q-ml-xs q-mt-xs"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
                <q-card-section>
                    <b>tabla de pagos</b>
                    <q-table
                        :columns="columns"
                        :rows="rows"
                        flat
                        dense
                        hide-bottom
                        table-header-class="header-no-bold"
                    />
                </q-card-section>
                <q-card-actions>
                    <btn-delete-component tooltips="vaciar cesta" />
                    <btn-shoppin-car-component />
                </q-card-actions>
            </q-card>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item class="bg-primary text-white">
                            <q-item-section> subtotal: </q-item-section>
                            <q-item-section avatar> 270 € </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section> pagos pendientes: </q-item-section>
                            <q-item-section avatar> 520 € </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section>
                                <q-item-label caption
                                    ><i
                                        >estas realizando una compra 100%
                                        segura</i
                                    ></q-item-label
                                >
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import BtnDeleteComponent from "../../components/btn/BtnDeleteComponent.vue";
import BtnShoppinCarComponent from "../../components/btn/BtnShoppinCarComponent.vue";

defineOptions({
    name: "Products",
});

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
        amount: "660 €",
    },
    {
        date: "01-09-2023",
        summary: "quinto pago",
        cost: "130 €",
        amount: "790 €",
    },
]);
</script>
