<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                post-on-update
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const name = {
    field: "name",
    name: "name",
    label: "nombre",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
        help: ["unico"],
    },
};

const price = {
    field: "price",
    name: "price",
    label: "precio",
    align: "left",
    sortable: true,
    type: "number",
    required: true,
    othersProps: {
        required: true,
    },
};

const firstPayment = {
    field: "first_payment",
    name: "first_payment",
    label: "pago inicial",
    align: "left",
    sortable: true,
    type: "number",
    required: true,
    othersProps: {
        required: true,
    },
};

const totalPayments = {
    field: "total_payments",
    name: "total_payments",
    label: "pagos totales",
    align: "left",
    sortable: true,
    type: "number",
    required: true,
    othersProps: {
        required: true,
    },
};

const total = {
    field: "total",
    name: "total",
    label: "cantidad",
    align: "left",
    sortable: true,
    type: "number",
    required: true,
    othersProps: {
        required: true,
    },
};

const description = {
    field: "description",
    name: "description",
    label: "descripcion",
    align: "left",
    sortable: true,
    type: "text",
    autogrow: true,
};

const image = {
    field: "image_path",
    name: "image_path",
    label: "imagen",
    align: "left",
    type: "image",
};

const searchFields = [name];

const columns = [
    {
        type: "image",
        field: "image_path",
        name: "image_path",
        label: "",
        align: "center",
        sortable: false,
        width: "100px",
    },
    name,
    price,
    total,
    firstPayment,
    totalPayments,
    description,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [
    name,
    price,
    total,
    firstPayment,
    totalPayments,
    description,
    image,
];
</script>
