<template>
    <Layout>
        <q-page padding>
            <table-component
                :searchFields="searchFields"
                :filterFields="filterFields"
                :updateFields="fields"
                :has_delete="false"
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/testimony/TableComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "ListPage",
});

const title = {
    field: "title",
    name: "title",
    label: "titulo",
    align: "left",
    sortable: true,
    type: "text",
};

const message = {
    field: "message",
    name: "message",
    label: "mensaje",
    align: "left",
    sortable: true,
    type: "text",
};

const message_to_admin = {
    field: "msg_to_admin",
    name: "msg_to_admin",
    label: "mensaje admin",
    align: "left",
    type: "text",
};

const name_to_show = {
    field: "name_to_show",
    name: "name_to_show",
    label: "nombre a mostrar",
    align: "left",
    type: "text",
};

const anonimous = {
    field: "anonimous",
    name: "anonimous",
    label: "anonimo",
    align: "center",
    type: "boolean",
    othersProps: {
        help: [
            "indica que el usuario es super-administrador, incluso sin tener rol o permiso asociado tiene acceso a todas las funcionalidades del sistema",
        ],
    },
};

const searchFields = [
    title,
    {
        field: "name_to_show",
        name: "name_to_show",
        label: "nombre a mostrar",
        type: "text",
    },
];

const fields = [name_to_show, title, message, message_to_admin, anonimous];

const filterFields = [
    {
        name: "type",
        label: "tipo",
        type: "select",
        options: [
            {
                label: "texto",
                value: "text",
            },
            {
                label: "video",
                value: "video",
            },
        ],
    },
    {
        name: "publicated",
        label: "publicado",
        type: "boolean",
    },
    {
        name: "anonimous",
        label: "anonimo",
        type: "boolean",
    },
];

if (usePage().props.auth.user.sa) {
    filterFields.push({
        name: "user_id",
        label: "usuario",
        type: "select",
        othersProps: {
            url_to_options: "/users",
        },
    });
}
</script>
