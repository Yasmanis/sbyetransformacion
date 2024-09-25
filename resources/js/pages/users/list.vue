<template>
    <Layout>
        <q-page padding>
            <table-component
                :toStr="toStr"
                :columns="columns"
                :data="data"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="createFields"
                :updateFields="updateFields"
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
        value: "username",
        label: "usuario",
    },
    {
        value: "name",
        label: "primer nombre",
    },
    {
        value: "surname",
        label: "apellidos",
    },
    {
        value: "email",
        label: "email",
    },
];

const filterFields = [
    {
        name: "active",
        label: "activo",
        type: "boolean",
        value: null,
    },
];

const columns = [
    {
        field: "username",
        name: "username",
        label: "usuario",
        align: "left",
        sortable: true,
        type: "text",
        required: true,
    },
    {
        field: "name",
        name: "name",
        label: "nombre",
        align: "left",
        sortable: true,
        type: "text",
    },
    {
        field: "surname",
        name: "surname",
        label: "apellidos",
        align: "left",
        sortable: true,
        type: "text",
    },
    {
        field: "email",
        name: "email",
        label: "email",
        align: "left",
        sortable: true,
        type: "text",
    },
    {
        field: "sa",
        name: "sa",
        label: "super admin",
        align: "center",
        type: "boolean",
    },
    {
        field: "active",
        name: "active",
        label: "activo",
        align: "center",
        type: "boolean",
    },
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
    },
];

const createFields = [
    {
        name: "name",
        label: "usuario",
        type: "text",
        props: {
            required: true,
        },
    },
    {
        name: "name",
        label: "apellidos",
        type: "text",
        props: {
            rules: [(val) => !!val || "Requerido"],
        },
    },
    {
        name: "surname",
        label: "apellidos",
        type: "text",
    },
    {
        name: "email",
        label: "email",
        type: "text",
        props: {
            required: true,
            type: "email",
        },
    },
    {
        name: "sa",
        label: "super admin",
        type: "checkbox",
    },
    {
        name: "active",
        label: "activo",
        type: "checkbox",
    },
];

const updateFields = [
    {
        name: "username",
        readonly: true,
        label: "username",
        type: "text",
    },
    {
        name: "name",
        label: "name",
        type: "text",
    },
    {
        name: "surname",
        label: "surname",
        type: "text",
    },
    {
        name: "email",
        label: "email",
        type: "text",
    },
    {
        name: "sa",
        label: "super admin",
        type: "checkbox",
    },
    {
        name: "active",
        label: "active",
        type: "checkbox",
    },
];
</script>
