<template>
    <Layout>
        <q-page padding
            ><table-component
                :columns="columns"
                :searchFields="searchFields"
                :filter-fields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                post-on-update
            ></table-component
        ></q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/products/TableComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

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

const price = {
    field: "price",
    name: "price",
    label: "precio",
    align: "left",
    sortable: true,
    type: "number",
    required: true,
    othersProps: {
        required: true,
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

const image = {
    field: "image_path",
    name: "image_path",
    label: "imagen",
    align: "left",
    type: "image",
};

const categories = {
    field: "categories_id",
    name: "categories_id",
    label: "categorias",
    type: "select",
    othersProps: {
        multiple: true,
        url_to_options: "/product-categories",
    },
};

const valoration = {
    field: "valoration",
    name: "valoration",
    label: "valoracion",
    align: "center",
    type: "rating",
    othersProps: {
        defaultValue: 5,
    },
};

const publicF = {
    field: "public",
    name: "public",
    label: "alta",
    align: "center",
    type: "boolean",
};

const clientsValoration = {
    field: "clients_valoration",
    name: "clients_valoration",
    label: "valoracion clientes",
    align: "center",
    type: "boolean",
};

const informationToLanding = {
    field: "information_to_landing",
    name: "information_to_landing",
    label: "informacion en landing",
    align: "center",
    type: "boolean",
};

const subtitles = {
    field: "subtitles",
    name: "subtitles",
    label: "subtitulos",
    type: "subtitles",
};

const searchFields = [name];

const filterFields = [publicF, clientsValoration, informationToLanding];

const columns = [
    {
        type: "image",
        field: "image_path",
        name: "image_path",
        label: "",
        align: "center",
        sortable: false,
        width: "100px",
        othersProps: {
            default: `${usePage().props.public_path}images/logo/${
                Dark.isActive ? "1" : "2"
            }.png`,
        },
    },
    name,
    price,
    valoration,
    clientsValoration,
    informationToLanding,
    description,
    {
        field: "categories_str",
        name: "categories_str",
        label: "categorias",
        align: "left",
        type: "text",
    },
    publicF,
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
    name,
    price,
    {
        field: "clients_valoration",
        name: "clients_valoration",
        label: "habilitar valoracion clientes",
        align: "center",
        type: "boolean",
    },
    valoration,
    description,
    subtitles,
    {
        field: "information_to_landing",
        name: "information_to_landing",
        label: "vincular landing a mas informacion",
        align: "center",
        type: "boolean",
    },
    image,
    categories,
    publicF,
    {
        field: "planes",
        name: "planes",
        label: "planes",
        type: "planes",
    },
];
</script>
