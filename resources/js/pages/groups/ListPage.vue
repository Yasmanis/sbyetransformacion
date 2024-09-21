<template>
    <q-page padding>
        <table-component
            :toStr="toStr"
            :columns="columns"
            :searchFields="searchFields"
            :createFields="fields"
            :updateFields="fields"
        ></table-component>
    </q-page>
</template>

<script setup>
import TableComponent from "../../components/table/TableComponent.vue";
import { $t } from "src/services/i18n";

defineOptions({
    name: "ListPage",
});

const toStr = null;

const searchFields = [
    {
        value: "name",
        label: $t("fields.name"),
    },
];

const columns = [
    {
        field: "name",
        required: true,
        name: "name",
        label: $t("fields.name"),
        align: "left",
        sortable: true,
        type: "text",
    },
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
    },
];

const fields = [
    {
        name: "name",
        label: $t("fields.name"),
        type: "text",
        options: {
            maxLength: 30,
            required: true,
            unique: true,
        },
    },
];
</script>
