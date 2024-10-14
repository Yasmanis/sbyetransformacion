<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :data="data"
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

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
});

const category = {
    field: "category",
    name: "category",
    label: "categoria",
    type: "select",
    align: "left",
    othersProps: {
        url_to_options: "/categories",
    },
};

const name = {
    field: "name",
    name: "name",
    label: "nombre",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
};

const type = {
    field: "type",
    name: "type",
    label: "tipo",
    align: "left",
    sortable: true,
    type: "text",
};

const size = {
    field: "size_str",
    name: "size_str",
    label: "tamaño",
    align: "left",
    sortable: true,
    type: "text",
    style: "width: 120px",
};

const files = {
    field: "files",
    name: "files",
    label: "ficheros",
    type: "uploader",
};

const searchFields = [name];

const columns = [
    name,
    type,
    size,
    category,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [
    name,
    {
        field: "category_id",
        name: "category_id",
        label: "categoria",
        type: "select",
        othersProps: {
            url_to_options: "/categories",
        },
    },
];
</script>
