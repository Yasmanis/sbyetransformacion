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
                :new-on-create="false"
                :segment="segment"
                post-on-update
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import { computed, onBeforeMount } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/pushmessage/TableComponent.vue";

defineOptions({
    name: "ListPage",
});

const segment = computed(() => {
    const pathSegments = window.location.pathname.split("/");
    return pathSegments.pop() || pathSegments[pathSegments.length - 2];
});

const campaigns = {
    field: "campaign_id",
    name: "campaign_id",
    label: "campaña",
    type: "campaign",
    othersProps: {
        url_to_options: "/selects/campaigns",
        required: true,
    },
};

const title = {
    field: "title",
    name: "title",
    label: "titulo",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        required: true,
    },
};

const message = {
    field: "message",
    name: "message",
    label: "mensaje",
    align: "left",
    sortable: true,
    type: "editor",
    required: true,
    othersProps: {
        required: true,
    },
};

const url = {
    field: "url",
    name: "url",
    label: "url",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
    othersProps: {
        type: "url",
    },
};

const logo = {
    field: "logo",
    name: "logo",
    label: "logo",
    type: "file",
    othersProps: {
        icon: "mdi-image-outline",
        titleIcon: "seleccionar imagen",
        accept: "image/*",
        change: true,
        helpCheck: "marque esta casilla si desea reemplazar el logo existente",
    },
};

const image = {
    field: "image",
    name: "image",
    label: "imagen adjunta",
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

const video = {
    field: "video",
    name: "video",
    label: "video adjunto",
    type: "file",
    othersProps: {
        icon: "mdi-video-outline",
        titleIcon: "seleccionar video",
        accept: "video/*",
        change: true,
        helpCheck: "marque esta casilla si desea reemplazar video existente",
    },
};

const action_title = {
    field: "action_button_title",
    name: "action_button_title",
    label: "boton de accion titulo",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
};

const action_url = {
    field: "action_button_url",
    name: "action_button_url",
    label: "boton de accion url",
    align: "left",
    sortable: true,
    type: "text",
    required: true,
};

const periodicity = {
    type: "periodicity",
    name: "periodicity",
};

const datetimerange = {
    type: "datetimerangefield",
    startName: "start_at",
    endName: "end_at",
    othersStartProps: {
        required: true,
    },
};

const state = {
    field: "status",
    name: "status",
    label: "estado",
    align: "left",
    type: "select",
    filterable: false,
    options: [
        { label: "activo", value: "activo" },
        { label: "inactivo", value: "inactivo" },
    ],
    othersProps: {
        required: true,
    },
};

const sections = {
    field: "sections_id",
    name: "sections_id",
    label: "secciones",
    type: "select",
    othersProps: {
        url_to_options: "/category-nomenclatures/section",
        multiple: true,
        required: true,
    },
};

const sections_str = {
    field: "sections_str",
    name: "sections_str",
    label: "secciones",
    align: "left",
    type: "text",
};

const campaign_str = {
    field: "campaign_str",
    name: "campaign_str",
    label: "campaña",
    align: "left",
    type: "text",
};

const searchFields = [title];

const filterFields = [sections];

const columns = [title];

const fields = [
    campaigns,
    title,
    message,
    url,
    logo,
    image,
    video,
    action_title,
    action_url,
    datetimerange,
    periodicity,
    state,
];

onBeforeMount(() => {
    if (segment.value === "briefideas") {
        columns.push(message);
    } else {
        columns.push({
            field: "created_at",
            name: "created_at",
            label: "alta",
            align: "left",
        });
        columns.push({
            field: "start_at",
            name: "start_at",
            label: "emitido",
            align: "left",
        });
        columns.push({
            field: "next",
            name: "next",
            label: "proxima",
            align: "left",
        });
        columns.push(state);
        columns.push(campaign_str);
    }
    columns.push(sections_str);
    columns.push({
        field: "actions",
        name: "actions",
        label: "Acciones",
        type: "actions",
        width: "160px",
    });
});
</script>
