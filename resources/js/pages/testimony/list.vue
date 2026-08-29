<template>
    <Layout>
        <q-page padding>
            <table-component
                :searchFields="searchFields"
                :filterFields="filterFields"
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
