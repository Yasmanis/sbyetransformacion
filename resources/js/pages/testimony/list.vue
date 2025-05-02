<template>
    <Layout>
        <q-page padding>
            <table-component
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
import TableComponent from "../../components/modules/testimony/TableComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "ListPage",
});

const amzonImage = {
    field: "amazon_image",
    name: "amazon_image",
    label: "",
    align: "center",
    type: "file",
};

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
    label: "marca esta casilla si quieres hacer un testimonio anonimo, aunque es preferible que utilices un pseudonimo o solo tu nombre o diminutivo",
    align: "center",
    type: "boolean",
};

const volumes = {
    field: "book_volume",
    name: "book_volume",
    label: "tomo",
    type: "select",
    align: "left",
    options: [
        {
            label: "tomo I",
            value: "tomo_1",
        },
        {
            label: "tomo II",
            value: "tomo_2",
        },
        {
            label: "tomo III",
            value: "tomo_3",
        },
    ],
    filterable: false,
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

const fields = [
    name_to_show,
    anonimous,
    title,
    message,
    message_to_admin,
    amzonImage,
    volumes,
];

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
    volumes,
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
