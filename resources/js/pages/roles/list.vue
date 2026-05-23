<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
                :isRowDisabled="isDisabled"
                :is-field-disabled="checkFieldDisabled"
                @change-selected="onChangeSelected"
            >
                <template #delete-on-row="props">
                    <btn-delete-component
                        disable
                        v-if="isDisabled(props.props.row)"
                    />
                </template>
                <template #body-selection="props">
                    <q-checkbox
                        v-model="props.props.selected"
                        size="sm"
                        disable
                        v-if="isDisabled(props.props.row)"
                    />
                </template>
            </table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";
import BtnEditComponent from "../../components/btn/BtnEditComponent.vue";
import BtnDeleteComponent from "../../components/btn/BtnDeleteComponent.vue";
import { ref } from "vue";

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

const permissions = {
    field: "permissions",
    name: "permissions",
    label: "permisos",
    type: "select",
    othersProps: {
        multiple: true,
        url_to_options: "/permissions",
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

const fields = [name, permissions];

const currentSelected = ref([]);

const isDisabled = (row) => {
    return ["usuario", "gestor", "facilitador", "administrador"].includes(
        row?.name?.toLowerCase(),
    );
};

const checkFieldDisabled = (item, fieldName) => {
    return isDisabled(item) && fieldName === "name";
};

const onChangeSelected = (selected = []) => {
    currentSelected.value = selected.filter((s) => !isDisabled(s));
};
</script>
