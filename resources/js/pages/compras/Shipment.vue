<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs ? 'q-pr-xs' : ''"
        >
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense
                        ><q-item class="bg-primary text-white">
                            <q-item-section>
                                1. SELECCIONA LA FORMA DE ENTREGA
                            </q-item-section> </q-item
                        ><q-item class="bg-primary text-white q-mt-md">
                            <q-item-section>
                                2. DIRECCION DE ENVIO
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
                                <q-item-label> pueblo – ciudad </q-item-label>
                                <q-item-label>
                                    cp – provincia (pais)
                                </q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-item style="padding: 0px 0px">
                            <q-item-section>
                                <checkbox-field
                                    label="direccion nueva para este envio"
                                />
                            </q-item-section>
                            <q-item-section avatar>
                                <btn-edit-component />
                            </q-item-section>
                        </q-item>
                        <q-item class="bg-primary text-white q-mt-md">
                            <q-item-section>
                                3. OBSERVACIONES PARA EL TRANSPORTISTA
                            </q-item-section>
                        </q-item>
                        <q-item style="padding: 10px 0px">
                            <q-item-section>
                                <editor-field />
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
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
                            <q-item-section> envio MRW </q-item-section>
                            <q-item-section avatar> 4,95 € </q-item-section>
                        </q-item>
                        <q-item class="text-bold">
                            <q-item-section> total </q-item-section>
                            <q-item-section avatar> 274,95 € </q-item-section>
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
import CheckboxField from "../../components/form/input/CheckboxField.vue";
import BtnEditComponent from "../../components/btn/BtnEditComponent.vue";
import EditorField from "../../components/form/input/EditorField.vue";
import { Screen } from "quasar";

defineOptions({
    name: "Shipment",
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
