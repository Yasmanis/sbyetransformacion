<template>
    <div class="row">
        <div class="col">
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
                            <q-item-section top>
                                <q-item-label class="text-bold">
                                    {{ product.name }}
                                </q-item-label>
                                <q-item-label>
                                    Precio: {{ product.final_price }} €
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar top>
                                <btn-delete-component
                                    @click="removeProductFromStorage(product)"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import { computed, onBeforeMount, ref } from "vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import BtnShoppinCarComponent from "../../../btn/BtnShoppinCarComponent.vue";
import { removeProductFromStorage } from "../../../../services/shopping";
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
