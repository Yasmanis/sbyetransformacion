<template>
    <Layout>
        <q-page>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="[filterFields]"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="true"
                @change-selected="(val) => (selected = val)"
            >
                <template #body-cell-families_str="{ props }">
                    <ul class="guion-list">
                        <li
                            v-for="fam in props.row.families_str"
                            :key="`fam-${fam}`"
                        >
                            {{ fam }}
                        </li>
                    </ul>
                </template>
                <template #top-actions="{ props }">
                    <form-family-component :subcategories="selected" />
                    <view-family-component />
                    <sort-elements-component
                        model="PublicationSubcategory"
                        tooltips="ordenar subcategorias"
                        :filter-columns="sortFilterColumns"
                        v-if="props.has_edit"
                    >
                        <template #top>
                            <select-field
                                :model-value="sortFilterColumns['category_id']"
                                name="category_id"
                                label="categoria"
                                :othersProps="{
                                    url_to_options: '/categories',
                                }"
                                @update="onChangeCategory"
                            />
                        </template>
                    </sort-elements-component>
                </template>
            </table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/PublicationsLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";
import SortElementsComponent from "../../components/others/SortElementsComponent.vue";
import SelectField from "../../components/form/input/SelectField.vue";

import FormFamilyComponent from "../../components/modules/publication_subcategory/FormFamilyComponent.vue";
import ViewFamilyComponent from "../../components/modules/publication_subcategory/ViewFamilyComponent.vue";
import { ref } from "vue";

defineOptions({
    name: "ListPage",
});

const selected = ref([]);

const sortFilterColumns = ref({});

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

const categoryStr = {
    field: "category_str",
    name: "category_str",
    label: "categoria",
    align: "left",
    sortable: false,
    type: "text",
};

const families = {
    field: "families_str",
    name: "families_str",
    label: "familias",
    align: "left",
    sortable: false,
    type: "list",
};

const category = {
    name: "category_id",
    label: "categoria",
    dependsOn: [],
    url: "/categories",
    method: "get",
    options: [],
    value: null,
    loading: false,
    disabled: false,
    resets: ["family"],
    type: "select",
    scope: "whereCategory",
};

const searchFields = [name];

const filterFields = {
    type: "dynamicselects",
    name: "families",
    fields: [
        {
            ...category,
        },
        {
            name: "family",
            label: "familia",
            dependsOn: ["category_id"],
            url: "/selects/families",
            method: "get",
            options: [],
            value: null,
            loading: false,
            disabled: true,
            resets: [],
            type: "select",
            scope: "whereFamily",
            optionValue: "id",
            optionLabel: "name",
        },
    ],
};

const columns = [
    name,
    categoryStr,
    families,
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
    {
        type: "dynamicselects",
        name: "families",
        fields: [
            {
                ...category,
                othersProps: {
                    required: true,
                },
            },
            {
                name: "families_id",
                label: "familia",
                dependsOn: ["category_id"],
                url: "/selects/families",
                method: "get",
                options: [],
                value: null,
                loading: false,
                disabled: true,
                resets: [],
                type: "select",
                scope: "whereFamily",
                optionValue: "id",
                optionLabel: "name",
                multiple: true,
            },
        ],
    },
];

const onChangeCategory = (name, val) => {
    sortFilterColumns.value[name] = val;
};
</script>
