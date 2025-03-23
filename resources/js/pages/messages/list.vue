<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                v-if="segment !== 'briefideas'"
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import { computed, onBeforeMount } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const segment = computed(() => {
    const pathSegments = window.location.pathname.split("/");
    return pathSegments.pop() || pathSegments[pathSegments.length - 2];
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

const created = {
    field: "created_at",
    name: "created_at",
    label: "fecha",
    align: "left",
    sortable: true,
    type: "date",
    othersProps: {
        required: true,
    },
};

const datetimerange = {
    type: "datetimerangefield",
    startName: "start_at",
    endName: "end_at",
    othersStartProps: {
        required: true,
    },
};

const importance = {
    field: "importance",
    name: "importance",
    label: "importancia",
    align: "left",
    sortable: true,
    type: "select",
    options: [
        {
            label: "alta",
            value: "alta",
        },
        {
            label: "media",
            value: "media",
        },
        {
            label: "baja",
            value: "baja",
        },
    ],
    othersProps: {
        required: true,
    },
};

const sections = {
    field: "sections_id",
    name: "sections_id",
    label: "secciones",
    type: "select",
    othersProps: {
        url_to_options: "/category-nomenclatures/panels",
        multiple: true,
        required: true,
    },
};

const sections_str = {
    field: "sections_str",
    name: "sections_str",
    label: "secciones",
    align: "left",
    type: "text",
};

const users = {
    name: "users_id",
    label: "este aviso es para",
    type: "users",
};

const client = {
    name: "assigned_to",
    label: "cliente asociado",
    type: "users",
    multiple: false,
    required: false,
};

const actions = {
    field: "actions",
    name: "actions",
    label: "Acciones",
    type: "actions",
    width: "100px",
};

const periodicity = {
    type: "periodicity",
    name: "periodicity",
};

const searchFields = [title];

const filterFields = [importance, sections, created];

const columns = [title, message, created, importance, sections_str, actions];

const fields = [
    title,
    message,
    users,
    client,
    datetimerange,
    periodicity,
    importance,
    sections,
];

onBeforeMount(() => {});
</script>
