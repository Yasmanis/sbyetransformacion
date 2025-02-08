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

const logo = {
    field: "logo",
    name: "logo",
    label: "",
    align: "left",
    type: "image",
};

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

const start = {
    field: "start_date",
    name: "start_date",
    label: "inicio",
    align: "left",
    sortable: true,
    type: "date",
};

const end = {
    field: "end_date",
    name: "end_date",
    label: "fin",
    align: "left",
    sortable: true,
    type: "date",
};

const sections = {
    field: "sections",
    name: "sections",
    label: "secciones",
    align: "left",
    type: "text",
};

const created = {
    field: "created_by",
    name: "created_by",
    label: "creada por",
    align: "left",
    type: "select",
    othersProps: {
        url_to_options: "/users",
    },
};

const searchFields = [name];

const filterFields = [start, end, created];

const columns = [
    logo,
    name,
    start,
    end,
    sections,
    created,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: 100,
    },
];

const fields = [name];
</script>
