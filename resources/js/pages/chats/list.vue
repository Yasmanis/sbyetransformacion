<template>
    <Layout>
        <q-page padding>
            <table-component
                :columns="columns"
                :searchFields="searchFields"
                :filterFields="filterFields"
                :createFields="fields"
                :updateFields="fields"
                :has_delete="false"
            >
                <template #body-cell-message="props">
                    <text-truncate :text="props.props.row.message" />
                </template>
                <template #item-section-message="props">
                    <text-truncate :text="props.props.row.message" />
                </template>
                <template #new-actions-on-row="props">
                    <btn-go-component
                        tooltips="ir al chat"
                        :href="`/admin/${props.props.row.segment}#chat-${props.props.row.id}-${props.props.row.topic_id}-${props.props.row.section_id}`"
                    />
                </template>
            </table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/table/TableComponent.vue";
import TextTruncate from "../../components/others/TextTruncate.vue";
import BtnGoComponent from "../../components/btn/BtnGoComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

defineOptions({
    name: "ListPage",
});

const page = usePage();

const react_range = computed(() => {
    return (
        page.props.react_range ?? {
            min: 0,
            max: 0,
        }
    );
});

const highligth_range = computed(() => {
    return (
        page.props.highligth_range ?? {
            min: 0,
            max: 0,
        }
    );
});

const response_range = computed(() => {
    return (
        page.props.response_range ?? {
            min: 0,
            max: 0,
        }
    );
});

const message = {
    field: "message",
    name: "message",
    label: "mensage",
    align: "left",
    sortable: true,
    type: "editor",
    required: true,
    othersProps: {
        required: true,
    },
};

const created_at = {
    field: "created_at",
    name: "created_at",
    label: "fecha",
    align: "left",
    sortable: true,
    type: "date",
};

const from_str = {
    field: "from_name",
    name: "from_name",
    label: "usuario",
    align: "left",
    sortable: false,
    type: "text",
};

const section_str = {
    field: "section_str",
    name: "section_str",
    label: "seccion",
    align: "left",
    sortable: false,
    type: "text",
};

const topic_str = {
    field: "topic_str",
    name: "topic_str",
    label: "tema",
    align: "left",
    sortable: false,
    type: "text",
};

const segment = {
    field: "segment_description",
    name: "segment_description",
    label: "modulo",
    align: "left",
    sortable: false,
    type: "text",
};

const searchFields = [message];

const columns = [
    message,
    created_at,
    from_str,
    segment,
    section_str,
    topic_str,
    {
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "190px",
    },
];

const fields = [message];

const filterFields = ref([
    created_at,
    {
        field: "from_id",
        name: "from_id",
        label: "usuario",
        type: "select",
        othersProps: {
            url_to_options: "/users",
        },
    },
    {
        field: "module",
        name: "module",
        label: "modulo",
        type: "select",
        scope: "whereCategory",
        othersProps: {
            url_to_options: "/chats-modules",
        },
    },
    {
        name: "response",
        label: "respuestas",
        type: "checkbox",
        modelValue: false,
        scope: "whereResponses",
    },
]);

onMounted(() => {
    if (react_range.value.min !== 0 || react_range.value.max !== 0) {
        filterFields.value.push({
            name: "react",
            label: "valoracion",
            type: "range",
            scope: "whereReact",
            value: null,
            ...react_range.value,
        });
    }
    if (highligth_range.value.min !== 0 || highligth_range.value.max !== 0) {
        filterFields.value.push({
            name: "highligth",
            label: "relevancia",
            type: "range",
            scope: "whereHighligth",
            value: null,
            ...highligth_range.value,
        });
    }
});
</script>
