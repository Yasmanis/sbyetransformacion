<template>
    <Layout>
        <q-page padding>
            <table-component
                :collection="collection"
                :labelPlural="labelPlural"
                :labelSingular="labelSingular"
                :toStr="toStr"
                :icon="icon"
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

const collection = "users";
const labelPlural = "usuarios";
const labelSingular = "usuario";
const toStr = null;
const icon = "mdi-account-outline";

const searchFields = [
    {
        value: "username",
        label: "usuario",
    },
    {
        value: "first_name",
        label: "primer nombre",
    },
    {
        value: "last_name",
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
        field: "first_name",
        name: "first_name",
        label: "nombre",
        align: "left",
        sortable: true,
        type: "text",
    },
    {
        field: "last_name",
        name: "last_name",
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
        name: "first_name",
        label: "apellidos",
        type: "text",
        props: {
            rules: [(val) => !!val || "Requerido"],
        },
    },
    {
        name: "last_name",
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
        name: "first_name",
        label: "first_name",
        type: "text",
    },
    {
        name: "last_name",
        label: "last_name",
        type: "text",
    },
    {
        name: "email",
        label: "email",
        type: "text",
    },
    {
        name: "active",
        label: "active",
        type: "checkbox",
    },
];
</script>
