<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
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

const name = {
    field: "title",
    name: "title",
    label: "titulo",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
        help: ["unico"],
    },
};

const message = {
    field: "message",
    name: "message",
    label: "mensaje",
    align: "left",
    type: "editor",
};

const sections = {
    field: "sections",
    name: "sections",
    label: "secciones",
    align: "left",
    type: "text",
};

const searchFields = [name];

const filterFields = [];

const columns = [
    name,
    message,
    sections,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: 100,
    },
];

const fields = [name, message];
</script>
