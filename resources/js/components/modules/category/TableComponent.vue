<template>
    <q-card flat bordered>
        <q-table :rows="rows" :columns="columns" :grid="$q.screen.lt.sm" :loading="loading"
            :visible-columns="visibleColumns" :rows-per-page-options="[10, 20, 30, 50, 100]" wrap-cells row-key="id"
            selection="multiple" v-model:selected="selected" v-model:pagination="pagination" binary-state-sort
            :selected-rows-label="(numberOfRows) =>
                `${numberOfRows} ${numberOfRows > 1
                    ? 'registros seleccionados'
                    : 'registro seleccionado'
                }`
                " :no-data-label="$page.props.search
                    ? 'no existen coincidencias'
                    : 'no existen datos'
                    " rows-per-page-label="registros por paginas" :pagination-label="(firstRowIndex, endRowIndex, totalRowsNumber) =>
                        `${firstRowIndex} - ${endRowIndex} de ${totalRowsNumber}`
                        " @request="onRequest">
            <template v-slot:top="props">
                <q-toolbar>
                    <section class="q-my-xs q-mr-sm cursor-pointer text-subtitle1">
                        <div class="doc-card-title bg-primary text-white">
                            <q-icon :name="current_module?.ico" size="22px" />
                            {{ current_module?.plural_label }}
                        </div>
                    </section>
                    <q-space />
                    <div class="col-auto">
                        <form-component :title="current_module.singular_label" :fields="createFields"
                            :module="current_module" size="sm" v-if="
                                createFields.length > 0 &&
                                has_add
                            " />
                        <q-btn-component tooltips="actualizar" icon="mdi-table-sync" @click="onRequest" />
                        <visible-columns-component :columns="columns" @change="(vc) => (visibleColumns = vc)" />
                        <q-btn-component :tooltips="props.inFullscreen ? 'restaurar' : 'maximizar'
                            " :icon="props.inFullscreen
                                ? 'fullscreen_exit'
                                : 'fullscreen'
                                " @click="props.toggleFullscreen" />
                        <delete-component :objects="selected" :module="current_module" @deleted="selected = []"
                            v-if="selected.length > 0 && has_delete" />
                    </div>
                </q-toolbar>
                <div class="row" style="
                        width: 100%;
                        border-top: 1px solid rgba(0, 0, 0, 0.12);
                        padding: 10px;
                    " v-if="searchFields.length > 0 || filterFields.length > 0">
                    <div class="col" v-if="searchFields.length > 0">
                        <search-component :fields="searchFields" @search="onSearch"
                            @reset="onSearchClear"></search-component>
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
                <q-th :props="props" :align="props.col.align" :class="props?.col?.name === 'actions'
                    ? 'last-column-sticky'
                    : ''
                    " v-if="props.col.type !== 'hidden'">
                    {{ props.col.name !== "actions" ? props.col.label : "" }}
                </q-th>
            </template>

            <template #body-cell="props">
                <q-td :props="props" :align="props.col.align" v-if="props.col.type !== 'hidden'">
                    <template v-if="props.col.type === 'avatar'">
                        <q-avatar v-if="props.value">
                            <q-img :src="props.value" loading="lazy" />
                        </q-avatar>
                        <q-avatar v-else>
                            <q-img src="~assets/default-avatar.png" loading="lazy" />
                        </q-avatar>
                    </template>
                    <template v-else-if="props.col.type === 'boolean'">
                        <q-chip dense size="sm" style="max-width: min-content"
                            :color="props.value ? 'positive' : 'negative'" text-color="white"
                            :icon="props.value ? 'check' : 'error'" :label="props.value ? 'Si' : 'No'" />
                    </template>
                    <template v-else-if="props.col.type === 'textarea'">
                        <span v-if="props.row[props.col.field].length <= 20">
                            {{ props.row[props.col.field] }}
                        </span>
                        <span v-else>{{ props.row[props.col.field].substring(0, 17) }}
                            <b>
                                ...
                                <q-tooltip class="bg-brown">Click para ver detalles</q-tooltip>
                            </b>
                        </span>
                    </template>
                    <template v-else>
                        {{ props.row[props.col.field] }}
                    </template>
                </q-td>
            </template>

            <template v-slot:body-cell-actions="props">
                <q-td :props="props" :style="{
                    position: 'sticky',
                    right: 0,
                    width: props.col.width,
                }" class="actions-def">
                    <form-component :object="props.row" :title="current_module.singular_label" :fields="updateFields"
                        :module="current_module" size="sm" v-if="updateFields.length > 0 && has_edit" />
                    <q-btn-component :tooltips="props.row.files.length === 0 ? '' : 'ordenar ficheros'" icon="mdi-sort"
                        @click="onShowSort(props.row.files)" :disable="props.row.files.length < 2" v-if="has_edit" />
                    <delete-component :objects="[props.row]" :module="current_module" size="sm" v-if="has_delete" />
                </q-td>
            </template>

            <template v-slot:item="props">
                <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <q-card style="margin-left: 10px; margin-right: 10px">
                        <q-list>
                            <q-item v-for="col in props.cols" :key="col.name"
                                :class="col.type === 'hidden' ? 'hidden' : ''">
                                <q-item-section v-if="col.name !== 'actions'">
                                    <q-item-label v-if="col.type !== 'avatar'">
                                        {{ col.label }}
                                    </q-item-label>
                                    <q-item-label v-if="col.type === 'avatar'" class="text-center">
                                        <q-avatar v-if="col.value">
                                            <q-img :src="col.value" loading="lazy" />
                                        </q-avatar>
                                        <q-avatar v-else>
                                            <q-img src="~assets/default-avatar.png" loading="lazy" />
                                        </q-avatar>
                                    </q-item-label>
                                    <q-item-label v-else-if="col.type === 'boolean'">
                                        <q-chip dense size="sm" style="max-width: min-content" :color="col.value
                                            ? 'positive'
                                            : 'negative'
                                            " text-color="white" :icon="col.value ? 'check' : 'error'
                                                " :label="col.value ? 'Si' : 'No'" />
                                    </q-item-label>
                                    <q-item-label caption v-else>{{
                                        col.value ? col.value : "..."
                                    }}</q-item-label>
                                </q-item-section>
                                <q-item-section v-else-if="col.name === 'actions'">
                                    <q-separator />
                                    <div class="q-pa-sm q-gutter-sm text-right">
                                        <form-component :object="props.row" :title="current_module.singular_label
                                            " :fields="updateFields" :module="current_module" size="sm" v-if="
                                                updateFields.length > 0 &&
                                                has_edit
                                            " />
                                        <delete-component :objects="[props.row]" :module="current_module" size="sm"
                                            v-if="has_delete" />
                                    </div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-card>
                </div>
            </template>
        </q-table>

        <q-dialog v-model="showDialog" persistent position="right">
            <q-card class="scroll">
                <dialog-header-component icon="mdi-sort" title="ordenar ficheros" closable />
                <q-card-section>
                    <ul id="items">
                        <li v-for="(f, index) in list" :key="`file-list-${index}`" :data-id="f.id"> {{ f.name }}
                        </li>
                    </ul>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right">
                    <q-btn-component label="guardar" outline square size="md" padding="5px" no_caps
                        icon="mdi-content-save-outline" @click="sortFiles" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-card>
</template>

<script setup>
import { ref, onBeforeMount, onMounted, computed, watch } from "vue";
import { useQuasar } from "quasar";
import FormComponent from "../../form/FormComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import VisibleColumnsComponent from "../../table/actions/VisibleColumnsComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import SearchComponent from "../../table/actions/SearchComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { currentModule } from "../../../services/current_module";
import { Sortable } from "@shopify/draggable";
import { useForm } from "@inertiajs/vue3";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";

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

const showDialog = ref(false);

const list = ref([]);

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

const has_add = ref(false);
const has_edit = ref(false);
const has_delete = ref(false);

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
    const permissions = current_module.value.permissions.map((p) => p.name);
    const modelName = current_module.value.model.toLowerCase();
    has_add.value = permissions.includes(`add_${modelName}`);
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);
});

onMounted(() => {
    visibleColumns.value = props.columns
        .filter((c) => c.type !== "hidden" && !c.required)
        .map((c) => c.field);

    new Sortable(document.querySelectorAll('ul#items'), {
        draggable: 'li',
        onUpdate: function (evt) {
            console.log(evt);
        }
    });
})

const onFilter = (filters) => { };

const onFilterClear = () => { };

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

const onShowSort = (files) => {
    list.value = files;
    showDialog.value = true;
}

const sortFiles = () => {
    const items = document.querySelectorAll('ul#items > li');
    let files = [];
    let index = 1;
    items.forEach(el => {
        files.push({
            id: el.getAttribute('data-id'),
            order: index
        });
        index++;
    });
    const send = useForm({
        ids: JSON.stringify(files)
    });
    send.post(`${current_module.value.base_url}/sort-files`, {
        onSuccess: () => {
            showDialog.value = false;
        },
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
tbody>tr>td:nth-child(1) {
    left: 0;
}

.q-table td.actions-def,
th:nth-child(1),
tbody>tr>td:nth-child(1),
.q-table th.last-column-sticky {
    position: sticky;
    z-index: 99;
    background-color: #fff;
}

.q-table--dark td.actions-def,
.q-table--dark th:nth-child(1),
.q-table--dark th.last-column-sticky,
.q-table--dark tbody>tr>td:nth-child(1) {
    background-color: #1d222e;
}

td.actions-def>.q-btn {
    margin-right: 3px;
}

.q-table th.last-column-sticky {
    right: 0;
}

ul#items {
    padding: 0;
}

ul#items>li {
    padding: 10px;
    list-style: none;
    cursor: pointer;
}

ul#items>li:hover {
    background-color: #cdcdcd;
}
</style>
