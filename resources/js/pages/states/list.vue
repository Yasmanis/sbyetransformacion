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

const country = {
    field: "country_id",
    name: "country_id",
    label: "pais",
    type: "select",
    align: "left",
    othersProps: {
        url_to_options: "/countries",
        required: true,
    },
};

const searchFields = [name];

const filterFields = [
    {
        field: "country_id",
        name: "country_id",
        label: "pais",
        type: "select",
        othersProps: {
            url_to_options: "/countries",
        },
    },
];

const columns = [
    name,
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

const fields = [name, country];
</script>
