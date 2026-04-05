<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :has_delete="false"
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/recycle_bin/TableComponent.vue";

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
};

const type = {
    field: "type",
    name: "type",
    label: "tipo",
    align: "left",
    sortable: true,
    type: "text",
};

const user = {
    field: "user",
    name: "user",
    label: "eliminado por",
    align: "left",
    sortable: true,
    type: "text",
};

const deleted = {
    field: "deleted_at",
    name: "deleted_at",
    label: "fecha eliminacion",
    type: "date",
    sortable: true,
    align: "center",
};

const permanent_deleted = {
    field: "permanent_deleted",
    name: "permanent_deleted",
    label: "eliminacion permanente",
    type: "date",
    sortable: true,
    align: "center",
};

const searchFields = [name];

const columns = [
    {
        field: "icon",
        name: "icon",
        label: "",
        align: "center",
        type: "text",
        style: "width: 20px; padding: 0px",
    },
    type,
    name,
    user,
    deleted,
    permanent_deleted,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "190px",
    },
];

const filterFields = [
    deleted,
    permanent_deleted,
    {
        field: "type",
        name: "type",
        label: "tipo",
        type: "select",
        scope: "ofType",
        othersProps: {
            url_to_options: "/select/models",
        },
    },
    {
        field: "deleted_by",
        name: "deleted_by",
        label: "eliminado por",
        type: "select",
        othersProps: {
            url_to_options: "/users",
        },
    },
];
</script>
