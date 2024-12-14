<template>
    <Layout>
        <q-page padding>
            testimonios
            <!-- <table-component
                :searchFields="searchFields"
                :filterFields="filterFields"
                :updateFields="fields"
                :has_delete="false"
            ></table-component> -->
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

const searchFields = [title];

const fields = [title, message];

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
