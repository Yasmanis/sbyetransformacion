<template>
    <q-table
        :rows="rows"
        :columns="
            onlyPercent ? columns.filter((c) => c.name !== 'income') : columns
        "
        :grid="$q.screen.lt.sm"
        :loading="loading"
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
            $page.props.search ? 'no existen coincidencias' : 'no existen datos'
        "
        rows-per-page-label="registros por paginas"
        :pagination-label="
            (firstRowIndex, endRowIndex, totalRowsNumber) =>
                `${firstRowIndex} - ${endRowIndex} de ${totalRowsNumber}`
        "
        @request="onRequest"
    >
        <template v-slot:top>
            <q-toolbar>
                <q-space />
                <div class="col-auto">
                    <form-component
                        title="adicionar descuento"
                        :fields="formFields"
                        :module="currentModule"
                        :axios-request="true"
                        size="sm"
                        @created="onRequest({ pagination })"
                        v-if="formFields.length > 0 && hasEdit"
                    />
                    <btn-reload-component @click="onRequest" />
                    <filter-component
                        :fields="filterFields"
                        @refresh-data="onRefreshData"
                        v-if="filterFields.length > 0"
                    />
                    <delete-component
                        :axios="true"
                        :objects="selected"
                        :url="currentModule.base_url"
                        @deleted="
                            () => {
                                selected = [];
                                onRequest({ pagination });
                            }
                        "
                        v-if="selected.length > 0 && hasEdit"
                    />
                </div>
            </q-toolbar>
            <div
                class="row"
                style="width: 100%"
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
                    props?.col?.name === 'actions' ? 'last-column-sticky' : ''
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
                    :module="currentModule"
                    title="editar oferta"
                    :fields="formFields"
                    :axios-request="true"
                    size="sm"
                    @updated="
                        onRequest({
                            pagination,
                        })
                    "
                    v-if="formFields.length > 0 && hasEdit"
                /><active-component
                    :object="props.row"
                    :base-url="baseUrl"
                    @save="
                        onRequest({
                            pagination,
                        })
                    "
                    v-if="hasEdit"
                />
                <delete-component
                    :axios="true"
                    :objects="[props.row]"
                    :url="currentModule.base_url"
                    size="sm"
                    @deleted="
                        onRequest({
                            pagination,
                        })
                    "
                    v-if="hasEdit"
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
                                        :color="col.value ? 'black' : 'blue-2'"
                                        :text-color="
                                            col.value ? 'white' : 'black'
                                        "
                                        :icon="col.value ? 'check' : 'error'"
                                        :label="col.value ? 'Si' : 'No'"
                                    />
                                </q-item-label>
                                <q-item-label caption v-else>
                                    <span
                                        v-html="col.value ? col.value : ''"
                                    ></span>
                                </q-item-label>
                            </q-item-section>
                            <q-item-section v-else-if="col.name === 'actions'">
                                <q-separator />
                                <div class="q-pa-sm q-gutter-sm text-right">
                                    <form-component
                                        :object="props.row"
                                        :module="currentModule"
                                        title="editar oferat"
                                        :fields="formFields"
                                        :axios-request="true"
                                        size="sm"
                                        @updated="
                                            onRequest({
                                                pagination,
                                            })
                                        "
                                        v-if="formFields.length > 0 && hasEdit"
                                    />
                                    <active-component
                                        :object="props.row"
                                        :base-url="baseUrl"
                                        @save="
                                            onRequest({
                                                pagination,
                                            })
                                        "
                                        v-if="hasEdit"
                                    />
                                    <delete-component
                                        :axios="true"
                                        :objects="[props.row]"
                                        :url="currentModule.base_url"
                                        size="sm"
                                        @deleted="
                                            onRequest({
                                                pagination,
                                            })
                                        "
                                        v-if="hasEdit"
                                    />
                                </div>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card>
            </div>
        </template>
    </q-table>
</template>

<script setup>
import { onMounted, ref } from "vue";
import FilterComponent from "../../table/actions/FilterComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import SearchComponent from "../../table/actions/SearchComponent.vue";
import FormComponent from "../../form/FormComponent.vue";
import BtnReloadComponent from "../../btn/BtnReloadComponent.vue";
import ActiveComponent from "./ActiveComponent.vue";
import { useQuasar } from "quasar";
import axios from "axios";

defineOptions({
    name: "DiscountsTable",
});

const props = defineProps({
    object: Object,
    hasEdit: Boolean,
    baseUrl: String,
    listUrl: String,
    priceName: {
        type: String,
        default: "price",
    },
    relationName: {
        type: String,
        default: "product_id",
    },
    onlyPercent: Boolean,
});
const $q = useQuasar();

const active = {
    field: "active",
    name: "active",
    label: "activo",
    align: "center",
    type: "boolean",
    othersProps: {
        help: ["indica si esta o no activo el descuento"],
    },
};

const columns = ref([
    {
        name: "code",
        field: "code",
        label: "codigo",
        sortable: true,
        align: "left",
    },
    {
        name: "percent",
        field: "percent",
        label: `${props.onlyPercent ? "descuento (%)" : "porciento"}`,
        sortable: true,
        align: "left",
    },
    {
        name: "income",
        field: "income",
        label: "descuento",
        sortable: true,
        align: "left",
    },
    {
        name: "offers_income",
        field: "offers_income",
        label: "descuento a oferta",
        sortable: false,
        type: "boolean",
        align: "center",
    },
    {
        name: "start_at",
        field: "start_at",
        label: "desde",
        sortable: true,
        align: "left",
    },
    {
        name: "end_at",
        field: "end_at",
        label: "hasta",
        sortable: true,
        align: "left",
    },
    {
        name: "description",
        field: "description",
        label: "descripcion",
        sortable: false,
        align: "left",
    },
    active,
    {
        name: "actions",
        field: "actions",
        sortable: true,
        align: "right",
    },
]);

const rows = ref([]);

const loading = ref(false);

const selected = ref([]);

const filterFields = ref([
    {
        name: "start_at",
        label: "desde",
        type: "date",
    },
    {
        name: "endt_at",
        label: "hasta",
        type: "date",
    },
    {
        field: "offers_income",
        name: "offers_income",
        label: "descuento aplicable a ofertas",
        type: "boolean",
    },
    active,
]);
const searchFields = ref([]);
const formFields = ref([
    {
        name: "code",
        label: "codigo",
        type: "text",
        othersProps: {
            required: true,
        },
    },
    {
        type: "discount",
        percentName: "percent",
        incomeName: "income",
        priceName: "price",
        totalPrice: props.object[props.priceName] ?? 0,
        onlyPercent: props.onlyPercent,
    },
    {
        type: "daterange",
        startName: "start_at",
        endName: "end_at",
        othersProps: {
            start: {
                required: true,
            },
        },
    },
    {
        name: props.relationName,
        type: "hidden",
        othersProps: {
            defaultValue: props.object.id,
        },
    },
    {
        name: "description",
        type: "editor",
        label: "descripcion",
        othersProps: {
            required: true,
        },
    },
    {
        field: "offers_income",
        name: "offers_income",
        label: "descuento aplicable a ofertas",
        type: "boolean",
        othersProps: {
            help: [
                "señala esta casilla si quieres que este descuento se pueda aplicar a las ofertas vigentes, reduciendo mas el PVP final",
            ],
        },
    },
    active,
]);

const currentModule = ref({
    to_str: null,
    singular_label: "descuento",
    plural_label: "descuentos",
    base_url: props.baseUrl,
});

const pagination = ref({
    descending: false,
    page: 1,
    rowsPerPage: 20,
    rowsNumber: 1,
    search: null,
    filters: null,
});

onMounted(() => {
    onRequest();
});

const onRefreshData = (prop, data) => {
    pagination.value[prop] =
        data !== undefined && data !== null ? JSON.stringify(data) : null;
    pagination.value.page = 1;
    onRequest();
};

const onRequest = async (attrs) => {
    loading.value = true;
    const { page, rowsPerPage, descending, sortBy, search, filters } = attrs
        ? attrs.pagination
        : pagination.value;
    const sortDirection = descending ? "DESC" : "ASC";
    axios
        .post(props.listUrl, {
            page,
            rowsPerPage,
            search,
            filters,
            sortBy,
            sortDirection,
        })
        .then((res) => {
            const { data, filters, search, sort } = res.data;
            rows.value = data.data;
            pagination.value.rowsNumber = data.total;
            pagination.value.rowsPerPage = data.per_page;
            pagination.value.page = data.current_page;
            if (sort) {
                pagination.value.sortBy = sort.sortBy;
                pagination.value.descending = sort.sortDirection === "DESC";
            }
            pagination.value.search = search ? JSON.stringify(search) : null;
            pagination.value.filters = filters ? JSON.stringify(filters) : null;
        })
        .finally(() => {
            loading.value = false;
        });
};
</script>
