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
import TableComponent from "../../components/modules/category/TableComponent.vue";

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

const subtitle = {
    field: "subtitle",
    name: "subtitle",
    label: "subtitulo",
    align: "left",
    sortable: true,
    type: "text",
};

const description = {
    field: "description",
    name: "description",
    label: "descripcion",
    align: "left",
    sortable: true,
    type: "editor",
};

const publicAccess = {
    field: "public_access",
    name: "public_access",
    label: "acceso publico",
    align: "center",
    type: "boolean",
};

const privateArea = {
    field: "private_area",
    name: "private_area",
    label: "area privada",
    align: "center",
    type: "boolean",
};

const searchFields = [name, subtitle];

const filterFields = [publicAccess, privateArea];

const columns = [
    name,
    subtitle,
    description,
    publicAccess,
    privateArea,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: 200,
    },
];

const fields = [name, subtitle, description, publicAccess, privateArea];
</script>
