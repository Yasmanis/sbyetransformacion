<template>
    <Layout>
        <q-page>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="true"
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/PublicationsLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";

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

const category = {
    field: "category_id",
    name: "category_id",
    label: "categoria",
    type: "select",
    othersProps: {
        url_to_options: "/categories",
        required: true,
    },
};

const categoryStr = {
    field: "category_str",
    name: "category_str",
    label: "categoria",
    align: "left",
    sortable: false,
    type: "text",
};

const searchFields = [name];

const filterFields = [category];

const columns = [
    name,
    categoryStr,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "160px",
    },
];

const fields = [name, category];
</script>
