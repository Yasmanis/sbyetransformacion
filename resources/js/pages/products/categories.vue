<template>
    <Layout>
        <q-page>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                post-on-update
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/ShoppingLayout.vue";
import TableComponent from "../../components/modules/products/categories/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

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
        help: ["unico"],
    },
};

const description = {
    field: "description",
    name: "description",
    label: "descripcion",
    align: "left",
    sortable: true,
    type: "editor",
    autogrow: true,
};

const subtitles = {
    field: "subtitles",
    name: "subtitles",
    label: "subtitulos",
    type: "subtitles",
};

const searchFields = [name];

const columns = [
    name,
    description,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "160px",
    },
];

const fields = [name, description, subtitles];
</script>
