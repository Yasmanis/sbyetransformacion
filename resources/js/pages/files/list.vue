<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :data="data"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
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

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
});

const searchFields = [
    {
        value: "name",
        label: "nombre",
    },
];

const columns = [
    {
        field: "name",
        name: "name",
        label: "nombre",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
    },
    {
        field: "type",
        name: "type",
        label: "tipo",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
    },
    {
        field: "size",
        name: "size",
        label: "tamaño",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
    },
    {
        field: "category",
        name: "category",
        label: "categoria",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
    },
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
    },
];

const fields = [
    {
        name: "name",
        label: "nombre",
        type: "text",
        props: {
            required: true,
        },
    },
];
</script>
