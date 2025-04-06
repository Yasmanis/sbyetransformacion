<template>
    <Layout>
        <q-page padding>
            <!-- <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
            ></table-component> -->
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

const state = {
    type: "state",
    country: {
        name: "country_id",
        label: "pais",
        othersProps: {
            url_to_options: "/countries",
            required: true,
        },
    },
    state: {
        name: "state_id",
        label: "estado",
        othersProps: {
            url_to_options: "/states",
            required: true,
        },
    },
};

const searchFields = [name];

const filterFields = [
    {
        type: "state",
        country: {
            name: "country_id",
            label: "pais",
        },
        state: {
            name: "state_id",
            label: "estado",
        },
    },
    {
        field: "country_id",
        name: "country_id",
        type: "hidden",
    },
    {
        field: "state_id",
        name: "state_id",
        type: "hidden",
    },
];

const columns = [
    name,
    {
        field: "state_str",
        name: "state_str",
        label: "estado",
        align: "left",
        type: "text",
    },
    {
        field: "country_str",
        name: "country_str",
        label: "pais",
        align: "left",
        type: "text",
    },
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [name, state];
</script>
