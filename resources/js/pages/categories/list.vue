<template>
    <Layout>
        <q-page padding>
            <table-component
                :toStr="toStr"
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
import Layout from "../../layouts/MainLayout.vue";
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

const toStr = null;

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
