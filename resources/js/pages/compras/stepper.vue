<template>
    <Layout>
        <q-page padding>
            <q-card>
                <q-card-section>
                    <q-stepper
                        v-model="step"
                        header-nav
                        ref="stepper"
                        color="primary"
                        header-class="custom-stepper-header"
                        animated
                    >
                        <q-step
                            :name="1"
                            title="MI CESTA"
                            icon="mdi-basket"
                            :done="step > 1"
                            :header-nav="step > 1"
                        >
                            <products />
                        </q-step>

                        <q-step
                            :name="2"
                            title="ENVIO"
                            icon="mdi-truck-fast-outline"
                            :done="step > 2"
                            :header-nav="step > 2"
                        >
                            <shipment />
                        </q-step>

                        <q-step
                            :name="3"
                            title="PAGO"
                            icon="mdi-currency-eur"
                            :done="step > 2"
                            :header-nav="step > 3"
                        >
                            <payment />
                        </q-step>

                        <q-step
                            :name="4"
                            title="CONFIRMACION"
                            icon="mdi-file-check-outline"
                            :header-nav="step > 4"
                        >
                            <confirmation />
                        </q-step>
                        <template v-slot:navigation>
                            <q-stepper-navigation>
                                <q-btn
                                    @click="$refs.stepper.next()"
                                    color="black"
                                    :label="
                                        step === 4 ? 'guardar' : 'siguiente'
                                    "
                                />
                                <q-btn
                                    v-if="step > 1"
                                    flat
                                    color="black"
                                    @click="$refs.stepper.previous()"
                                    label="anterior"
                                    class="q-ml-sm"
                                />
                            </q-stepper-navigation>
                        </template>
                    </q-stepper>
                </q-card-section>
            </q-card>
        </q-page>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import Shipment from "./Shipment.vue";
import Payment from "./Payment.vue";
import Confirmation from "./Confirmation.vue";
import Products from "./Products.vue";

defineOptions({
    name: "StepperPage",
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
