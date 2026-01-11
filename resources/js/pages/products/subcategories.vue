<template>
    <Layout>
        <q-page>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
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
import TableComponent from "../../components/modules/products/subcategories/TableComponent.vue";
import { Dark } from "quasar";
import { usePage } from "@inertiajs/vue3";

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
        url_to_options: "/product-categories",
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

const description = {
    field: "description",
    name: "description",
    label: "descripcion",
    align: "left",
    sortable: true,
    type: "editor",
    autogrow: true,
};

const end_text = {
    field: "end_text",
    name: "end_text",
    label: "texto final",
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

const black_image = {
    field: "black_image",
    name: "black_image",
    label: "imagen negra",
    type: "file",
    othersProps: {
        icon: "mdi-image-outline",
        titleIcon: "seleccionar imagen negra",
        accept: "image/*",
        change: true,
        helpCheck:
            "marque esta casilla si desea reemplazar la imagen existente",
    },
};

const white_image = {
    field: "white_image",
    name: "white_image",
    label: "imagen blanca",
    type: "file",
    othersProps: {
        icon: "mdi-image-outline",
        titleIcon: "seleccionar imagen blanca",
        accept: "image/*",
        change: true,
        helpCheck:
            "marque esta casilla si desea reemplazar la imagen existente",
    },
};

const searchFields = [name];

const filterFields = [category];

const columns = [
    {
        type: "image",
        field: "black_image_path",
        name: "black_image_path",
        label: "imagen negra",
        align: "center",
        sortable: false,
        width: "100px",
        othersProps: {
            default: `${usePage().props.public_path}images/logo/${
                Dark.isActive ? "1" : "2"
            }.png`,
        },
    },
    {
        type: "image",
        field: "white_image_path",
        name: "white_image_path",
        label: "imagen blanca",
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
    categoryStr,
    description,
    end_text,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "160px",
    },
];

const fields = [
    name,
    category,
    black_image,
    white_image,
    description,
    subtitles,
    end_text,
];
</script>
