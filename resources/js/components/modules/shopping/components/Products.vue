<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item style="padding-left: 0">
                            <q-item-section avatar top>
                                <q-img
                                    :src="`${$page.props.public_path}${
                                        product.image_path?.substring(1) ??
                                        'images/logo/2.png'
                                    }`"
                                    width="70px"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label class="text-bold">
                                    {{ product.name }}
                                </q-item-label>
                                <q-item-label>contado</q-item-label>
                                <q-item-label
                                    ><ul class="q-ma-none q-pl-md text-body2">
                                        <li>
                                            pago inicial
                                            {{
                                                product.total_to_car *
                                                product.first_payment
                                            }}
                                            €
                                        </li>
                                        <li>
                                            {{ product.total_payments }} pagos
                                            mensuales de
                                            {{ amountPerPayment }}
                                            €
                                        </li>
                                    </ul></q-item-label
                                >
                                <q-item-label class="text-bold">
                                    {{ product.total_to_car * product.price }} €
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar top>
                                <q-input
                                    v-model="product.total_to_car"
                                    dense
                                    outlined
                                    style="width: 50px"
                                />
                            </q-item-section>
                            <q-item-section
                                avatar
                                top
                                style="padding: 0px; min-width: 20px"
                            >
                                <btn-delete-component
                                    class="q-ml-xs q-mt-xs"
                                    @click="removeProductFromStorage(product)"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item class="bg-primary text-white">
                            <q-item-section> subtotal: </q-item-section>
                            <q-item-section avatar>
                                {{
                                    product.total_to_car * product.first_payment
                                }}
                                €
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section> pagos pendientes: </q-item-section>
                            <q-item-section avatar>
                                {{
                                    product.total_to_car *
                                    (product.price - product.first_payment)
                                }}
                                €
                            </q-item-section>
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
    <payments-table :product="object" />
</template>

<script setup>
import { computed, onBeforeMount, ref } from "vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnShoppinCarComponent from "../../../btn/BtnShoppinCarComponent.vue";
import { removeProductFromStorage } from "../../../../services/shopping";
import PaymentsTable from "./PaymentsTable.vue";
import { date } from "quasar";

defineOptions({
    name: "Products",
});

const props = defineProps({
    object: Object,
});

const product = ref(null);

const payments_str = [
    "primer",
    "segundo",
    "tercer",
    "cuarto",
    "quinto",
    "sexto",
    "septimo",
    "octavo",
    "noveno",
    "decimo",
];

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

const amountPerPayment = computed(() => {
    return round(
        product.value.total_to_car *
            ((product.value.price - product.value.first_payment) /
                product.value.total_payments)
    );
});

const round = (val) => {
    return Math.round(val * 100) / 100;
};

const rows = computed(() => {
    const firstDate = new Date();
    let nextDate = firstDate;

    const { total_to_car, first_payment, total_payments } = product.value;

    const fp = total_to_car * first_payment;
    let data = [
        {
            date: date.formatDate(firstDate, "DD-MM-YYYY"),
            summary: "primer pago con la compra",
            cost: `${fp}  €`,
            amount: `${fp}  €`,
        },
    ];

    for (let i = 1; i <= total_payments; i++) {
        nextDate = date.addToDate(nextDate, { months: 1 });
        data.push({
            date: date.formatDate(nextDate, "DD-MM-YYYY"),
            summary: `${payments_str[i]} pago con la compra`,
            cost: `${amountPerPayment.value}  €`,
            amount: `${round(amountPerPayment.value * i + fp)}  €`,
        });
    }
    return data;
});

onBeforeMount(() => {
    product.value = props.object;
});
</script>
