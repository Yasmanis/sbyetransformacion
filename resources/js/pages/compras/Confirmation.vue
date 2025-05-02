<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : ''"
        >
            <div class="row">
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs && !Screen.sm ? 'q-pr-md' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white">
                                    <q-item-section class="text-center">
                                        DIRECCION DE ENVIO
                                    </q-item-section>
                                </q-item>
                                <q-item style="padding: 10px 0px">
                                    <q-item-section>
                                        <q-item-label>
                                            nombre apellido apellido
                                        </q-item-label>
                                        <q-item-label>
                                            direccion completa
                                        </q-item-label>
                                        <q-item-label>
                                            pueblo – ciudad
                                        </q-item-label>
                                        <q-item-label>
                                            cp – provincia (pais)
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs ? 'q-pr-xs' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white">
                                    <q-item-section class="text-center">
                                        DIRECCION DE FACTURACION
                                    </q-item-section> </q-item
                                ><q-item style="padding: 10px 0px">
                                    <q-item-section>
                                        <q-item-label>
                                            nombre apellido apellido
                                        </q-item-label>
                                        <q-item-label>
                                            direccion completa
                                        </q-item-label>
                                        <q-item-label>
                                            pueblo – ciudad
                                        </q-item-label>
                                        <q-item-label>
                                            cp – provincia (pais)
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="row">
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs && !Screen.sm ? 'q-pr-md' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white q-mt-md">
                                    <q-item-section class="text-center">
                                        METODO DE PAGO
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs ? 'q-pr-xs' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white q-mt-md">
                                    <q-item-section class="text-center">
                                        METODO DE ENVIO
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="row">
                <div
                    class="col"
                    :class="!Screen.xs && !Screen.sm ? 'q-pr-xs' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white q-mt-md">
                                    <q-item-section>
                                        RESUMEN DE TU PEDIDO
                                    </q-item-section>
                                </q-item>
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
                                            ><ul
                                                class="q-ma-none q-pl-md text-body2"
                                            >
                                                <li>pago inicial 270 €</li>
                                                <li>
                                                    4 pagos mensuales de 130 €
                                                </li>
                                            </ul></q-item-label
                                        >
                                        <q-item-label class="text-bold">
                                            790 €
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
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
                    />
                </div>
            </div>
            <div class="row q-mt-sm">
                <div class="col">
                    <q-btn-component
                        label="leer terminos legales de esta contratacion"
                        flat
                        no-caps
                        square
                        color="primary"
                    />
                </div>
            </div>
        </div>
        <div
            class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
            :class="!Screen.xs ? 'q-pl-xs' : ''"
        >
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
                            <checkbox-field
                                label="acepto los terminos legales de esta contratacion"
                            />
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
import CheckboxField from "../../components/form/input/CheckboxField.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import { Screen } from "quasar";

defineOptions({
    name: "Confirmation",
});

const step = ref(1);

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
