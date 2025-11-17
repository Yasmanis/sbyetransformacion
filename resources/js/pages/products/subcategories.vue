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

const image = {
    field: "image",
    name: "image",
    label: "imagen",
    type: "file",
    othersProps: {
        icon: "mdi-image-outline",
        titleIcon: "seleccionar imagen",
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

const fields = [name, category, image, description, subtitles, end_text];
</script>
