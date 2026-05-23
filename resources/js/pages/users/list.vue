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
import TableComponent from "../../components/modules/user/TableComponent.vue";

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
    label: "alta",
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
        label: "alta",
        type: "boolean",
        value: null,
    },
    {
        name: "sa",
        label: "super admin",
        type: "boolean",
        value: null,
    },
    // {
    //     name: "role",
    //     label: "rol",
    //     type: "select",
    //     scope: "whereRole",
    //     value: null,
    //     othersProps: {
    //         url_to_options: "/roles",
    //     },
    // },
    // {
    //     name: "country",
    //     label: "pais",
    //     type: "select",
    //     scope: "whereCountry",
    //     value: null,
    //     othersProps: {
    //         multiple: true,
    //         url_to_options: "/countries",
    //     },
    // },
    // {
    //     name: "birthdate",
    //     label: "fecha nacimiento",
    //     type: "date",
    //     scope: "whereBirthdate",
    //     value: null,
    // },
    // {
    //     name: "age",
    //     label: "edad",
    //     type: "range",
    //     scope: "whereAge",
    //     value: null,
    //     min: 15,
    //     max: 120,
    // },
    // {
    //     name: "seniority",
    //     label: "antigüedad",
    //     type: "range",
    //     scope: "whereSeniority",
    //     value: null,
    //     min: 0,
    //     max: 60,
    // },
    // {
    //     name: "genre",
    //     label: "genero",
    //     type: "select",
    //     scope: "whereGenre",
    //     value: null,
    //     options: [
    //         {
    //             label: "masculino",
    //             value: "m",
    //         },
    //         {
    //             label: "femenino",
    //             value: "f",
    //         },
    //     ],
    // },
    // {
    //     name: "books",
    //     label: "libros",
    //     type: "select",
    //     scope: "whereVolume",
    //     value: null,
    //     options: [
    //         {
    //             label: "tomo I",
    //             value: "tomo_1",
    //         },
    //         {
    //             label: "tomo II",
    //             value: "tomo_2",
    //         },
    //         {
    //             label: "tomo III",
    //             value: "tomo_3",
    //         },
    //     ],
    // },
];

const columns = [
    {
        name: "note",
        field: "note",
        label: "",
        type: "notes",
    },
    name,
    surname,
    active,
    {
        name: "roles_str",
        label: "roles",
        field: "roles_str",
        type: "list",
        align: "left",
    },
    {
        name: "facilitator",
        label: "facilitador",
        field: "facilitator",
        type: "text",
        align: "left",
    },
    {
        name: "manager",
        label: "manager",
        field: "gestor",
        type: "text",
        align: "left",
    },
    actions,
];

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
