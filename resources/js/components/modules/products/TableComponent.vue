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
                            <q-icon
                                :name="
                                    current_module.ico_from_path
                                        ? `img:${$page.props.public_path}${current_module.ico}`
                                        : current_module.ico
                                "
                                size="22px"
                                v-if="current_module"
                            />
                            {{ current_module?.plural_label }}
                        </div>
                    </section>
                    <q-space />
                    <div class="col-auto">
                        <form-component
                            :title="current_module.singular_label"
                            :fields="createFields"
                            :module="current_module"
                            :new-on-create="newOnCreate"
                            :close-confirm="true"
                            size="sm"
                            v-if="createFields.length > 0 && has_add"
                        />
                        <sort-elements-component
                            :items="rows"
                            :url="`${current_module.base_url}/sort`"
                            tooltips="ordenar productos"
                            v-if="has_edit"
                        />
                        <btn-reload-component @click="onRequest" />
                        <visible-columns-component
                            :columns="columns"
                            @change="(vc) => (visibleColumns = vc)"
                        />
                        <filter-component
                            :fields="filterFields"
                            @refresh-data="onRefreshData"
                            v-if="filterFields.length > 0"
                        />
                        <delete-component
                            :objects="selected"
                            :url="current_module.base_url"
                            @deleted="selected = []"
                            v-if="selected.length > 0 && has_delete"
                        />
                        <q-btn-component
                            tooltips="limpiar todo"
                            icon="mdi-eraser"
                            @click="router.get(current_module.base_url)"
                            v-if="
                                pagination.filters ||
                                pagination.search ||
                                pagination.sortBy ||
                                pagination.page > 1
                            "
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
                            @refresh-data="onRefreshData"
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
                    :width="props.col.width"
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
                    <template
                        v-if="
                            props.col.type === 'avatar' ||
                            props.col.type === 'image'
                        "
                    >
                        <q-avatar v-if="props.col.type === 'avatar'">
                            <q-img :src="props.value" loading="lazy" />
                        </q-avatar>
                        <q-img
                            :src="
                                props.value ??
                                props.col.othersProps?.default ??
                                null
                            "
                            loading="lazy"
                            width="70px"
                            v-else
                        />
                    </template>
                    <template v-else-if="props.col.type === 'boolean'">
                        <q-chip
                            dense
                            size="sm"
                            style="max-width: min-content"
                            :color="props.value ? 'black' : 'blue-2'"
                            :text-color="props.value ? 'white' : 'black'"
                            :icon="props.value ? 'check' : 'error'"
                            :label="props.value ? 'Si' : 'No'"
                        />
                    </template>
                    <template v-else>
                        <q-item-label lines="5">
                            <span v-html="props.row[props.col.field]"> </span>
                        </q-item-label>
                    </template>
                </q-td>
            </template>

            <template v-slot:body-cell-actions="props">
                <q-td
                    :props="props"
                    :style="{
                        position: 'sticky',
                        right: 0,
                        width: props.col.width,
                    }"
                    class="actions-def"
                >
                    <form-component
                        :object="props.row"
                        :title="current_module.singular_label"
                        :fields="updateFields"
                        :module="current_module"
                        :post-on-update="postOnUpdate"
                        :close-confirm="true"
                        size="sm"
                        v-if="updateFields.length > 0 && has_edit"
                    />

                    <form-component
                        :object="props.row"
                        :duplicate="true"
                        title="current_module.singular_label"
                        :fields="updateFields"
                        :module="current_module"
                        :post-on-update="postOnUpdate"
                        :close-confirm="true"
                        size="sm"
                        v-if="updateFields.length > 0 && has_edit"
                    />

                    <btn-public-component
                        :public="props.row.public"
                        titlePublic="dar alta"
                        titleHide="dar baja"
                        v-if="has_edit"
                        @click="
                            router.post(
                                `/admin/products/public/${props.row.id}`,
                            )
                        "
                    />
                    <offers-component
                        :object="props.row"
                        base-discount-url="/admin/discounts"
                        :list-discount-url="`/admin/products/discounts/${props.row.id}`"
                        base-offer-url="/admin/offers"
                        :list-offer-url="`/admin/products/offers/${props.row.id}`"
                        :has-edit="has_edit"
                    />
                    <plane-field
                        :parent="props.row"
                        :has-edit="has_edit"
                        :in-form="false"
                    />
                    <delete-component
                        :objects="[props.row]"
                        :url="current_module.base_url"
                        size="sm"
                        v-if="has_delete"
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
                                        v-if="
                                            col.type === 'avatar' ||
                                            col.type === 'image'
                                        "
                                        class="text-center"
                                    >
                                        <q-avatar v-if="col.type === 'avatar'">
                                            <q-img
                                                :src="col.value"
                                                loading="lazy"
                                            />
                                        </q-avatar>
                                        <q-img
                                            :src="col.value"
                                            loading="lazy"
                                            width="100px"
                                            v-else
                                        />
                                    </q-item-label>
                                    <q-item-label
                                        v-else-if="col.type === 'boolean'"
                                    >
                                        <q-chip
                                            dense
                                            size="sm"
                                            style="max-width: min-content"
                                            :color="
                                                col.value ? 'black' : 'blue-2'
                                            "
                                            :text-color="
                                                col.value ? 'white' : 'black'
                                            "
                                            :icon="
                                                col.value ? 'check' : 'error'
                                            "
                                            :label="col.value ? 'Si' : 'No'"
                                        />
                                    </q-item-label>
                                    <q-item-label caption v-else>
                                        <span
                                            v-html="col.value ? col.value : ''"
                                        ></span>
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section
                                    v-else-if="col.name === 'actions'"
                                >
                                    <q-separator />
                                    <div class="q-pa-sm q-gutter-sm text-right">
                                        <form-component
                                            :object="props.row"
                                            :title="
                                                current_module.singular_label
                                            "
                                            :fields="updateFields"
                                            :module="current_module"
                                            :close-confirm="true"
                                            size="sm"
                                            v-if="
                                                updateFields.length > 0 &&
                                                has_edit
                                            "
                                        />
                                        <btn-public-component
                                            :public="props.row.public"
                                            titlePublic="dar alta"
                                            titleHide="dar baja"
                                            v-if="has_edit"
                                            @click="
                                                router.post(
                                                    `/admin/products/public/${props.row.id}`,
                                                )
                                            "
                                        />
                                        <offers-component
                                            :object="props.row"
                                            base-discount-url="/admin/discounts"
                                            :list-discount-url="`/admin/products/discounts/${props.row.id}`"
                                            base-offer-url="/admin/offers"
                                            :list-offer-url="`/admin/products/offers/${props.row.id}`"
                                            :has-edit="has_edit"
                                        />
                                        <plane-field
                                            :parent="props.row"
                                            :has-edit="has_edit"
                                            :in-form="false"
                                        />
                                        <delete-component
                                            :objects="[props.row]"
                                            :url="current_module.base_url"
                                            size="sm"
                                            v-if="has_delete"
                                        />
                                    </div>
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
import FormComponent from "../../form/FormComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import VisibleColumnsComponent from "../../table/actions/VisibleColumnsComponent.vue";
import SearchComponent from "../../table/actions/SearchComponent.vue";
import FilterComponent from "../../table/actions/FilterComponent.vue";
import BtnReloadComponent from "../../btn/BtnReloadComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnPublicComponent from "../../btn/BtnPublicComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { getActiveModule } from "../../../services/current_module";
import OffersComponent from "./OffersComponent.vue";
import PlaneField from "../../form/input/PlaneField.vue";
import SortElementsComponent from "../../others/SortElementsComponent.vue";

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
    postOnUpdate: {
        type: Boolean,
        default: false,
    },
    newOnCreate: {
        type: Boolean,
        default: true,
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
    filters: null,
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
        pagination.value.filters = val.filters
            ? JSON.stringify(val.filters)
            : null;
    },
    {
        immediate: true,
        deep: true,
    },
);

onBeforeMount(() => {
    current_module.value = getActiveModule();
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
});

const onRefreshData = (prop, data) => {
    pagination.value[prop] =
        data !== undefined && data !== null ? JSON.stringify(data) : null;
    pagination.value.page = 1;
    onRequest();
};

const onRequest = async (attrs) => {
    const { page, rowsPerPage, descending, sortBy, search, filters } = attrs
        ? attrs.pagination
        : pagination.value;
    const sortDirection = descending ? "DESC" : "ASC";
    router.get(
        "",
        { page, rowsPerPage, search, filters, sortBy, sortDirection },
        {
            preserveState: true,
        },
    );
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
