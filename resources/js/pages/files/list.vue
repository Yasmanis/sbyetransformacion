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
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/file/TableComponent.vue";

defineOptions({
    name: "ListPage",
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
    othersProps: {
        required: true,
    },
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
    width: "130px",
};

const files = {
    field: "files",
    name: "files",
    label: "ficheros",
    type: "uploader",
};

const public_access = {
    field: "public_access",
    name: "public_access",
    label: "publico",
    align: "center",
    type: "boolean",
};
const public_date = {
    field: "public_date",
    name: "public_date",
    label: "publicacion",
    type: "date",
    sortable: true,
    align: "left",
};

const fileChange = {
    field: "file",
    name: "file",
    label: "nuevo archivo",
    type: "file",
    sortable: true,
    align: "left",
    othersProps: {
        change: true,
        icon: "mdi-file-outline",
    },
};

const searchFields = [name];

const columns = [
    name,
    type,
    size,
    category,
    public_access,
    public_date,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "190px",
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
            required: true,
        },
    },
    {
        field: "public_access",
        name: "public_access",
        label: "acceso publico",
        align: "center",
        type: "boolean",
        othersProps: {
            help: [
                "marque esta casilla si desea que el/los fichero(s) tengan acceso publico",
            ],
        },
    },
    public_date,
    fileChange,
];

const filterFields = [
    {
        field: "category_id",
        name: "category_id",
        label: "categoria",
        type: "select",
        othersProps: {
            url_to_options: "/categories",
        },
    },
    {
        field: "type_scope",
        name: "type_scope",
        label: "tipo",
        type: "select",
        scope: "typeOfFile",
        othersProps: {
            url_to_options: "/type-of-files",
        },
    },
    {
        field: "size",
        name: "size",
        label: "tamaño",
        type: "range_size",
    },
    public_access,
    public_date,
];
</script>
