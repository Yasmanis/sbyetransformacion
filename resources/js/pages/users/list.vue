<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
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
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const username = {
    field: "username",
    name: "username",
    label: "usuario",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
        help: ["unico"],
    },
};

const name = {
    field: "name",
    name: "name",
    label: "nombre",
    align: "left",
    sortable: true,
    type: "text",
};

const surname = {
    field: "surname",
    name: "surname",
    label: "apellidos",
    align: "left",
    sortable: true,
    type: "text",
};

const email = {
    field: "email",
    name: "email",
    label: "correo",
    align: "left",
    sortable: true,
    type: "text",
    othersProps: {
        required: true,
        type: "email",
        help: ["unico"],
    },
};

const password = {
    field: "password",
    name: "password",
    label: "contraseña",
    type: "password",
    othersProps: {
        required: true,
        minLength: 8,
    },
};

const sa = {
    field: "sa",
    name: "sa",
    label: "super admin",
    align: "center",
    type: "boolean",
    othersProps: {
        help: [
            "indica que el usuario es super-administrador, incluso sin tener rol o permiso asociado tiene acceso a todas las funcionalidades del sistema",
        ],
    },
};

const active = {
    field: "active",
    name: "active",
    label: "activo",
    align: "center",
    type: "boolean",
    othersProps: {
        help: [
            "indica que el usuario esta activo en el sistema, sin esta opcion no puede acceder al mismo",
        ],
    },
};

const roles = {
    field: "roles",
    name: "roles",
    label: "roles",
    type: "select",
    othersProps: {
        multiple: true,
        url_to_options: "/roles",
    },
};

const permissions = {
    field: "permissions",
    name: "permissions",
    label: "permisos",
    type: "select",
    othersProps: {
        multiple: true,
        url_to_options: "/permissions",
    },
};

const actions = {
    field: "actions",
    name: "actions",
    label: "Acciones",
    type: "actions",
    width: "100px",
};

const searchFields = [username, name, surname, email];

const filterFields = [
    {
        name: "active",
        label: "activo",
        type: "boolean",
        value: null,
    },
];

const columns = [username, name, surname, email, sa, active, actions];

const createFields = [
    username,
    name,
    surname,
    email,
    password,
    sa,
    active,
    roles,
    permissions,
];

const updateFields = [name, surname, email, sa, active, roles, permissions];
</script>
