<template>
    <b>tabla de pagos</b>
    <q-table
        :columns="columns"
        :rows="rows"
        flat
        dense
        hide-bottom
        table-header-class="header-no-bold"
        :rows-per-page-options="[0]"
    />
</template>

<script setup>
import { date } from "quasar";
import { computed, ref } from "vue";

defineOptions({
    name: "PaymentsTable",
});

const props = defineProps({
    product: Object,
});

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
        props.product.total_to_car *
            ((props.product.price - props.product.first_payment) /
                props.product.total_payments)
    );
});

const round = (val) => {
    return Math.round(val * 100) / 100;
};

const rows = computed(() => {
    const firstDate = new Date();
    let nextDate = firstDate;

    const { total_to_car, first_payment, total_payments } = props.product;

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
</script>
