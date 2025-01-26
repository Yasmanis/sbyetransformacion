<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
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

const title = {
    field: "title",
    name: "title",
    label: "titulo",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
    },
};

const message = {
    field: "message",
    name: "message",
    label: "mensaje",
    align: "left",
    sortable: true,
    type: "editor",
    required: true,
    othersProps: {
        required: true,
    },
};

const image = {
    field: "image",
    name: "image",
    label: "imagen",
    type: "file",
    othersProps: {
        icon: "mdi-image-outline",
        titleIcon: "seleccionar imagen",
        accept: "image/*",
    },
};

const video = {
    field: "video",
    name: "video",
    label: "video",
    type: "file",
    othersProps: {
        icon: "mdi-video-outline",
        titleIcon: "seleccionar video",
        accept: "video/*",
    },
};

const action_title = {
    field: "action_title",
    name: "action_title",
    label: "boton de accion titulo",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
};

const action_url = {
    field: "action_url",
    name: "action_url",
    label: "boton de accion url",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
};

const periodicity = {
    type: "periodicity",
};

const state = {
    field: "state",
    name: "state",
    label: "estado",
    align: "left",
    type: "select",
    filterable: false,
    options: [
        { label: "activo", value: "activo" },
        { label: "inactivo", value: "inactivo" },
    ],
    othersProps: {
        required: true,
    },
};

const searchFields = [title];

const columns = [
    title,
    message,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [
    title,
    message,
    image,
    video,
    action_title,
    action_url,
    periodicity,
    state,
];
</script>
