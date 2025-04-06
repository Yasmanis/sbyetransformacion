<template>
    <Layout>
        <q-page padding>
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

const phonecode = {
    field: "phonecode",
    name: "phonecode",
    label: "codigo telefonico",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
        help: ["unico"],
    },
};

const searchFields = [name];

const columns = [
    name,
    phonecode,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "100px",
    },
];

const fields = [name, phonecode];
</script>
