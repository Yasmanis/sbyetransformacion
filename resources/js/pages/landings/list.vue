<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filter-fields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                post-on-update
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/landings/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const url = {
    field: "url",
    name: "url",
    label: "url",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
        help: ["unico"],
    },
};

const text = {
    field: "text",
    name: "text",
    label: "texto",
    align: "left",
    sortable: true,
    type: "editor",
    autogrow: true,
};

const image = {
    field: "image_path",
    name: "image_path",
    label: "imagen",
    align: "left",
    type: "image",
};

const logo = {
    field: "logo",
    name: "logo",
    label: "mostrar logo",
    align: "center",
    type: "boolean",
};

const product = {
    field: "product_id",
    name: "product_id",
    label: "producto",
    type: "select",
    align: "left",
    othersProps: {
        url_to_options: "/products",
    },
};

const searchFields = [url];

const filterFields = [logo, product];

const columns = [
    image,
    url,
    text,
    logo,
    {
        field: "product_str",
        name: "product_str",
        label: "producto",
        align: "left",
        type: "text",
    },
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "130px",
    },
];

const fields = [
    {
        name: "id",
    },
    url,
    text,
    image,
    logo,
    product,
];
</script>
