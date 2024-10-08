<template>
    <q-card flat bordered>
        <q-table
            :rows="rows"
            :columns="columns"
            :grid="$q.screen.lt.sm"
            :loading="loading"
            :visible-columns="visibleColumns"
            :rows-per-page-options="[10, 20, 30, 50, 100]"
            wrap-cells
            row-key="id"
            selection="multiple"
            v-model:selected="selected"
            v-model:pagination="pagination"
            binary-state-sort
            :selected-rows-label="
                (numberOfRows) =>
                    `${numberOfRows} ${
                        numberOfRows > 1
                            ? 'registros seleccionados'
                            : 'registro seleccionado'
                    }`
            "
            :no-data-label="
                $page.props.search
                    ? 'no existen coincidencias'
                    : 'no existen datos'
            "
            rows-per-page-label="registros por paginas"
            :pagination-label="
                (firstRowIndex, endRowIndex, totalRowsNumber) =>
                    `${firstRowIndex} - ${endRowIndex} de ${totalRowsNumber}`
            "
            @request="onRequest"
        >
            <template v-slot:top="props">
                <q-toolbar>
                    <section
                        class="q-my-xs q-mr-sm cursor-pointer text-subtitle1"
                    >
                        <div class="doc-card-title bg-primary text-white">
                            <q-icon :name="current_module?.ico" size="22px" />
                            {{ current_module?.plural_label }}
                        </div>
                    </section>
                    <q-space />
                    <div class="col-auto">
                        <form-component
                            :title="current_module.singular_label"
                            :fields="createFields"
                            :module="current_module"
                            size="sm"
                            v-if="
                                createFields.length > 0 &&
                                current_module.model !== 'File'
                            "
                        />
                        <form-file
                            :title="current_module.singular_label"
                            :module="current_module"
                            size="sm"
                            @save="onRequest"
                            v-if="current_module.model === 'File'"
                        />
                        <q-btn-component
                            tooltips="actualizar"
                            icon="mdi-table-sync"
                            @click="onRequest"
                        />
                        <visible-columns-component
                            :columns="columns"
                            @change="(vc) => (visibleColumns = vc)"
                        />
                        <q-btn-component
                            :tooltips="
                                props.inFullscreen ? 'restaurar' : 'maximizar'
                            "
                            :icon="
                                props.inFullscreen
                                    ? 'fullscreen_exit'
                                    : 'fullscreen'
                            "
                            @click="props.toggleFullscreen"
                        />
                    </div>
                </q-toolbar>
                <div
                    class="row"
                    style="
                        width: 100%;
                        border-top: 1px solid rgba(0, 0, 0, 0.12);
                        padding: 10px;
                    "
                    v-if="searchFields.length > 0 || filterFields.length > 0"
                >
                    <div class="col" v-if="searchFields.length > 0">
                        <search-component
                            :fields="searchFields"
                            @search="onSearch"
                            @reset="onSearchClear"
                        ></search-component>
                    </div>
                </div>
            </template>

            <template v-slot:header-selection="scope">
                <q-checkbox v-model="scope.selected" size="sm" />
            </template>

            <template v-slot:body-selection="scope">
                <q-checkbox v-model="scope.selected" size="sm" />
            </template>
            <template #header-cell="props">
                <q-th
                    :props="props"
                    :align="props.col.align"
                    :class="
                        props?.col?.name === 'actions'
                            ? 'last-column-sticky'
                            : ''
                    "
                    v-if="props.col.type !== 'hidden'"
                >
                    {{ props.col.name !== "actions" ? props.col.label : "" }}
                </q-th>
            </template>

            <template #body-cell="props">
                <q-td
                    :props="props"
                    :align="props.col.align"
                    v-if="props.col.type !== 'hidden'"
                >
                    <template v-if="props.col.type === 'avatar'">
                        <q-avatar v-if="props.value">
                            <q-img :src="props.value" loading="lazy" />
                        </q-avatar>
                        <q-avatar v-else>
                            <q-img
                                src="~assets/default-avatar.png"
                                loading="lazy"
                            />
                        </q-avatar>
                    </template>
                    <template v-else-if="props.col.type === 'boolean'">
                        <q-chip
                            dense
                            size="sm"
                            style="max-width: min-content"
                            :color="props.value ? 'positive' : 'negative'"
                            text-color="white"
                            :icon="props.value ? 'check' : 'error'"
                            :label="props.value ? 'Si' : 'No'"
                        />
                    </template>
                    <template v-else-if="props.col.type === 'textarea'">
                        <span v-if="props.row[props.col.field].length <= 20">
                            {{ props.row[props.col.field] }}
                        </span>
                        <span v-else
                            >{{ props.row[props.col.field].substring(0, 17) }}
                            <b>
                                ...
                                <q-tooltip class="bg-brown"
                                    >Click para ver detalles</q-tooltip
                                >
                            </b>
                        </span>
                    </template>
                    <template v-else>
                        {{ props.row[props.col.field] }}
                    </template>
                </q-td>
            </template>

            <template v-slot:body-cell-actions="props">
                <q-td
                    :props="props"
                    style="width: 0; position: sticky; right: 0"
                    class="actions-def"
                >
                    <form-component
                        :object="props.row"
                        :title="current_module.singular_label"
                        :fields="updateFields"
                        :module="current_module"
                        size="sm"
                        @updated="onUpdated"
                        v-if="updateFields.length > 0"
                    />
                </q-td>
            </template>

            <template v-slot:item="props">
                <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <q-card style="margin-left: 10px; margin-right: 10px">
                        <q-list>
                            <q-item
                                v-for="col in props.cols"
                                :key="col.name"
                                :class="col.type === 'hidden' ? 'hidden' : ''"
                            >
                                <q-item-section v-if="col.name !== 'actions'">
                                    <q-item-label v-if="col.type !== 'avatar'">
                                        {{ col.label }}
                                    </q-item-label>
                                    <q-item-label
                                        v-if="col.type === 'avatar'"
                                        class="text-center"
                                    >
                                        <q-avatar v-if="col.value">
                                            <q-img
                                                :src="col.value"
                                                loading="lazy"
                                            />
                                        </q-avatar>
                                        <q-avatar v-else>
                                            <q-img
                                                src="~assets/default-avatar.png"
                                                loading="lazy"
                                            />
                                        </q-avatar>
                                    </q-item-label>
                                    <q-item-label
                                        v-else-if="col.type === 'boolean'"
                                    >
                                        <q-chip
                                            dense
                                            size="sm"
                                            style="max-width: min-content"
                                            :color="
                                                col.value
                                                    ? 'positive'
                                                    : 'negative'
                                            "
                                            text-color="white"
                                            :icon="
                                                col.value ? 'check' : 'error'
                                            "
                                            :label="col.value ? 'Si' : 'No'"
                                        />
                                    </q-item-label>
                                    <q-item-label caption v-else>{{
                                        col.value ? col.value : "..."
                                    }}</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-card>
                </div>
            </template>
        </q-table>
    </q-card>
</template>

<script setup>
import { ref, onBeforeMount, onMounted, computed, watch } from "vue";
import { useQuasar } from "quasar";
import FormComponent from "../form/FormComponent.vue";
import FormFile from "../file/FormFile.vue";
import VisibleColumnsComponent from "./actions/VisibleColumnsComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import SearchComponent from "./actions/SearchComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { currentModule } from "../../services/current_module";

defineOptions({
    name: "TableComponent",
});

const props = defineProps({
    columns: {
        type: Array,
        default: () => [],
    },
    searchFields: {
        type: Array,
        default: () => [],
    },
    filterFields: {
        type: Array,
        default: () => [],
    },
    updateFields: {
        type: Array,
        default: () => [],
    },
    createFields: {
        type: Array,
        default: () => [],
    },
});

const $q = useQuasar();

const page = usePage();

const loading = ref(false);

const current_module = ref(null);

const pagination = ref({
    descending: false,
    page: 1,
    rowsPerPage: 20,
    rowsNumber: 1,
    search: null,
    filters: [],
});

const selected = ref([]);

const visibleColumns = ref([]);

const properties = computed(() => {
    return page.props;
});

const rows = ref([]);

watch(
    properties,
    (val) => {
        const data = val.data;
        rows.value = data.data;
        pagination.value.rowsNumber = data.total;
        pagination.value.rowsPerPage = data.per_page;
        pagination.value.page = data.current_page;
        if (val.sort) {
            pagination.value.sortBy = val.sort.sortBy;
            pagination.value.descending = val.sort.sortDirection === "DESC";
        }
        pagination.value.search = val.search
            ? JSON.stringify(val.search)
            : null;
    },
    {
        immediate: true,
        deep: true,
    }
);

onBeforeMount(() => {
    current_module.value = currentModule(page.url.split("?")[0]).module;
});

onMounted(() => {
    visibleColumns.value = props.columns
        .filter((c) => c.type !== "hidden" && !c.required)
        .map((c) => c.field);
});

const onFilter = (filters) => {};

const onFilterClear = () => {};

const onSearch = (attrs) => {
    pagination.value.search = JSON.stringify(attrs);
    pagination.value.page = 1;
    onRequest();
};

const onSearchClear = () => {
    pagination.value.search = null;
    pagination.value.page = 1;
    onRequest();
};

const onUpdated = (record) => {
    onRequest();
};

const onDeleted = (objects) => {};

const onRequest = async (attrs) => {
    const { page, rowsPerPage, descending, sortBy, search, filters } = attrs
        ? attrs.pagination
        : pagination.value;
    const sortDirection = descending ? "DESC" : "ASC";
    router.get("", {
        page,
        rowsPerPage,
        sortBy,
        sortDirection,
        search,
        filters,
    });
};
</script>
<style>
.q-table__top {
    padding: 0px !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.q-table__top .q-btn {
    margin-left: 5px;
}

.doc-card-title {
    margin-left: -24px;
    padding: 2px 10px 2px 24px;
    position: relative;
    border-radius: 3px 5px 5px 0;
}

.doc-card-title:after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    width: 0;
    height: 0;
    border: 0 solid transparent;
    border-top-color: var(--q-primary);
    border-width: 9px 0 0 11px;
}

.doc-card-title .q-icon {
    margin-top: -3px;
}

th:nth-child(1),
tbody > tr > td:nth-child(1) {
    left: 0;
}

.q-table td.actions-def,
th:nth-child(1),
tbody > tr > td:nth-child(1),
.q-table th.last-column-sticky {
    position: sticky;
    z-index: 99;
    background-color: #fff;
}

.q-table--dark td.actions-def,
.q-table--dark th:nth-child(1),
.q-table--dark th.last-column-sticky,
.q-table--dark tbody > tr > td:nth-child(1) {
    background-color: #1d222e;
}

td.actions-def > .q-btn {
    margin-right: 3px;
}

.q-table th.last-column-sticky {
    right: 0;
}
</style>
