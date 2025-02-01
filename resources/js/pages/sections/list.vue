<template>
    <Layout>
        <q-page padding>
            secciones
            <!-- <table-component
                :columns="columns"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
            ></table-component> -->
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const name = {
    field: "value",
    name: "value",
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

const key = {
    field: "key",
    name: "key",
    type: "hidden",
    othersProps: {
        defaultValue: "section",
    },
};

const searchFields = [name];

const columns = [
    name,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [name, key];
</script>
