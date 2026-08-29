<template>
    <q-btn-component
        icon="mdi-video-account"
        tooltips="testimonios"
        color="white"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        full-width
        persistent
        @before-show="onRequest"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-video-account"
                title="testimonios"
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <q-table
                    :rows="rows"
                    :columns="columns"
                    :grid="$q.screen.lt.sm"
                    :loading="loading"
                    :visible-columns="visibleColumns"
                    :rows-per-page-options="[10, 20, 30, 50, 100]"
                    row-key="id"
                    selection="multiple"
                    v-model:selected="selected"
                    v-model:pagination="pagination"
                    binary-state-sort
                    wrap-cells
                    flat
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
                    style="max-height: 60vh"
                    @request="onRequest"
                >
                    <template v-slot:top="props">
                        <q-toolbar>
                            <q-space />
                            <div class="col-auto">
                                <btn-reload-component @click="onRequest" />
                                <visible-columns-component
                                    :columns="columns"
                                    @change="(vc) => (visibleColumns = vc)"
                                />
                                <filter-component
                                    ref="filterRef"
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
                                <btn-clear-component
                                    @click="onClear"
                                    v-if="
                                        (pagination.filters &&
                                            pagination.filters?.length > 0) ||
                                        pagination.search ||
                                        pagination.sortBy ||
                                        pagination.page > 1
                                    "
                                />
                                <btn-full-screen-component
                                    :full="props.inFullscreen"
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
                            v-if="
                                searchFields.length > 0 ||
                                filterFields.length > 0
                            "
                        >
                            <div class="col" v-if="searchFields.length > 0">
                                <search-component
                                    ref="searchRef"
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
                            {{
                                props.col.name !== "actions"
                                    ? props.col.label
                                    : ""
                            }}
                        </q-th>
                    </template>

                    <template #body-cell="props">
                        <q-td
                            :props="props"
                            :align="props.col.align"
                            v-if="props.col.type !== 'hidden'"
                        >
                            <template v-if="props.col.type === 'avatar'">
                                <q-img
                                    :src="`${$page.props.public_path}storage/${props.row.amazon_image}`"
                                    loading="lazy"
                                    width="50px"
                                    height="50px"
                                    img-class="cursor-pointer"
                                    fit="fill"
                                    @click="
                                        openImage(
                                            `${$page.props.public_path}storage/${props.row.amazon_image}`,
                                        )
                                    "
                                    v-if="props.row.amazon_image"
                                    ><q-tooltip-component
                                        title="click para ampliar"
                                /></q-img>
                                <q-icon
                                    name="mdi-help-circle-outline"
                                    size="50px"
                                    v-else
                                    ><q-tooltip-component
                                        title="no existe imagen para este testimonio"
                                /></q-icon>
                            </template>
                            <template v-else-if="props.col.type === 'boolean'">
                                <q-chip
                                    dense
                                    size="sm"
                                    style="max-width: min-content"
                                    :color="props.value ? 'black' : 'blue-2'"
                                    :text-color="
                                        props.value ? 'white' : 'black'
                                    "
                                    :icon="props.value ? 'check' : 'error'"
                                    :label="props.value ? 'Si' : 'No'"
                                />
                            </template>
                            <template v-else-if="props.col.name === 'message'">
                                <q-btn-component
                                    icon="mdi-message-video"
                                    color="primary"
                                    tooltips="reproducir mensaje"
                                    flat
                                    dense
                                    square
                                    size="md"
                                    target="_blank"
                                    :href="`${$page.props.public_path}storage/${props.row.path}`"
                                    v-if="props.row.file_type === 'video'"
                                />
                                <text-truncate
                                    :text="props.row.message"
                                    v-else
                                />
                            </template>
                            <template v-else>
                                <span v-html="props.value"></span>
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
                                :exclude-user="true"
                                post-on-update
                                axios-request
                                size="sm"
                                @updated="onRequest"
                                v-if="has_edit"
                            />
                            <btn-public-component
                                :public="props.row.publicated"
                                @click="onPublicated(props.row.id)"
                                v-if="has_edit"
                            />
                            <delete-component
                                :objects="[props.row]"
                                :url="current_module.base_url"
                                :axios="true"
                                size="sm"
                                @deleted="onRequest"
                                v-if="has_delete"
                            />
                        </q-td>
                    </template>

                    <template v-slot:item="props">
                        <div
                            class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3"
                        >
                            <q-card
                                style="margin-left: 10px; margin-right: 10px"
                            >
                                <q-list>
                                    <q-item
                                        v-for="col in props.cols"
                                        :key="col.name"
                                        :class="
                                            col.type === 'hidden'
                                                ? 'hidden'
                                                : ''
                                        "
                                    >
                                        <q-item-section
                                            v-if="col.name !== 'actions'"
                                        >
                                            <q-item-label
                                                v-if="col.type !== 'avatar'"
                                            >
                                                {{ col.label }}
                                            </q-item-label>
                                            <q-item-label
                                                v-if="col.type === 'avatar'"
                                                class="text-center"
                                            >
                                                <q-img
                                                    :src="`${$page.props.public_path}storage/${props.row.amazon_image}`"
                                                    loading="lazy"
                                                    width="50px"
                                                    height="50px"
                                                    img-class="cursor-pointer"
                                                    fit="fill"
                                                    @click="
                                                        openImage(
                                                            `${$page.props.public_path}storage/${props.row.amazon_image}`,
                                                        )
                                                    "
                                                    v-if="
                                                        props.row.amazon_image
                                                    "
                                                    ><q-tooltip-component
                                                        title="click para ampliar"
                                                /></q-img>
                                                <q-icon
                                                    name="mdi-help-circle-outline"
                                                    size="50px"
                                                    v-else
                                                    ><q-tooltip-component
                                                        title="no existe imagen para este testimonio"
                                                /></q-icon>
                                            </q-item-label>
                                            <q-item-label
                                                v-else-if="
                                                    col.type === 'boolean'
                                                "
                                            >
                                                <q-chip
                                                    dense
                                                    size="sm"
                                                    style="
                                                        max-width: min-content;
                                                    "
                                                    :color="
                                                        col.value
                                                            ? 'black'
                                                            : 'blue-2'
                                                    "
                                                    :text-color="
                                                        col.value
                                                            ? 'white'
                                                            : 'black'
                                                    "
                                                    :icon="
                                                        col.value
                                                            ? 'check'
                                                            : 'error'
                                                    "
                                                    :label="
                                                        col.value ? 'Si' : 'No'
                                                    "
                                                />
                                            </q-item-label>
                                            <q-item-label
                                                caption
                                                v-else-if="
                                                    col.name === 'message'
                                                "
                                            >
                                                <q-btn-component
                                                    icon="mdi-message-video"
                                                    color="primary"
                                                    tooltips="reproducir mensaje"
                                                    flat
                                                    dense
                                                    square
                                                    size="md"
                                                    target="_blank"
                                                    :href="`${$page.props.public_path}storage/${props.row.path}`"
                                                    v-if="
                                                        props.row.file_type ===
                                                        'video'
                                                    "
                                                />
                                                <span
                                                    v-html="col.value"
                                                    v-else
                                                ></span>
                                            </q-item-label>
                                            <q-item-label caption v-else>{{
                                                col.value ? col.value : "..."
                                            }}</q-item-label>
                                        </q-item-section>
                                        <q-item-section
                                            v-else-if="col.name === 'actions'"
                                        >
                                            <q-separator />
                                            <div
                                                class="q-pa-sm q-gutter-sm text-right"
                                            >
                                                <form-component
                                                    :object="props.row"
                                                    :title="
                                                        current_module.singular_label
                                                    "
                                                    :fields="updateFields"
                                                    :module="current_module"
                                                    :exclude-user="true"
                                                    post-on-update
                                                    axios-request
                                                    @updated="onRequest"
                                                    size="sm"
                                                    v-if="has_edit"
                                                />
                                                <btn-public-component
                                                    :public="
                                                        props.row.publicated
                                                    "
                                                    @click="
                                                        onPublicated(
                                                            props.row.id,
                                                        )
                                                    "
                                                    v-if="has_edit"
                                                />
                                                <delete-component
                                                    :objects="[props.row]"
                                                    :url="
                                                        current_module.base_url
                                                    "
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
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, onBeforeMount, onMounted, computed, watch } from "vue";
import { useQuasar, openURL, Loading } from "quasar";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnReloadComponent from "../../btn/BtnReloadComponent.vue";
import FormComponent from "../testimony/FormComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import VisibleColumnsComponent from "../../table/actions/VisibleColumnsComponent.vue";
import SearchComponent from "../../table/actions/SearchComponent.vue";
import FilterComponent from "../../table/actions/FilterComponent.vue";
import BtnFullScreenComponent from "../../btn/BtnFullScreenComponent.vue";
import BtnClearComponent from "../../btn/BtnClearComponent.vue";
import BtnPublicComponent from "../../btn/BtnPublicComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import TextTruncate from "../../others/TextTruncate.vue";
import SortElementsComponent from "../../others/SortElementsComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { getActiveModule } from "../../../services/current_module";
import axios from "axios";
import { success } from "../../../helpers/notifications.js";

defineOptions({
    name: "TableComponent",
});

const props = defineProps({
    updateFields: {
        type: Array,
        default: () => [],
    },
    user: Object,
});

const $q = useQuasar();

const page = usePage();

const loading = ref(false);

const showDialog = ref(false);

const searchFields = [
    {
        field: "name",
        name: "name",
        label: "titulo",
        align: "left",
        sortable: true,
        type: "text",
    },
];

const filterFields = [
    {
        name: "type",
        label: "tipo",
        type: "select",
        options: [
            {
                label: "texto",
                value: "text",
            },
            {
                label: "video",
                value: "video",
            },
        ],
    },
    {
        name: "publicated",
        label: "publicado",
        type: "boolean",
    },
    {
        name: "anonimous",
        label: "anonimo",
        type: "boolean",
    },
    {
        field: "book_volume",
        name: "book_volume",
        label: "tomo",
        type: "select",
        align: "left",
        options: [
            {
                label: "tomo I",
                value: "tomo_1",
            },
            {
                label: "tomo II",
                value: "tomo_2",
            },
            {
                label: "tomo III",
                value: "tomo_3",
            },
        ],
        filterable: false,
    },
];

const volumes = {
    tomo_1: "tomo I",
    tomo_2: "tomo II",
    tomo_3: "tomo III",
};

const sa = computed(() => {
    return page.props.auth.user.sa;
});

const columns = ref([
    {
        field: "amazon_image",
        name: "amazon_image",
        label: "",
        align: "center",
        type: "avatar",
    },
    {
        field: "name",
        name: "name",
        label: "titulo",
        align: "left",
        required: true,
        sortable: true,
        type: "text",
    },
    {
        field: "message",
        name: "message",
        label: "mensaje",
        align: "left",
        type: "text",
    },
    {
        field: "book_volume",
        name: "book_volume",
        label: "tomo",
        align: "left",
        type: "text",
        format: (val) => {
            return val ? volumes[val] : null;
        },
    },
    {
        field: "publicated",
        name: "publicated",
        label: "publicado",
        type: "boolean",
        align: "center",
    },
    {
        field: "anonimous",
        name: "anonimous",
        label: "anonimo",
        type: "boolean",
        align: "center",
    },
    {
        field: "name_to_show",
        name: "name_to_show",
        label: "nombre mostrar",
        align: "left",
        type: "text",
    },
    {
        field: "msg_to_admin",
        name: "msg_to_admin",
        label: "mensaje admin",
        align: "left",
        type: "text",
    },
]);

columns.value.push({
    field: "actions",
    name: "actions",
    label: "Acciones",
    type: "actions",
    width: 130,
});

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

const has_edit = ref(false);
const has_delete = ref(false);

const searchRef = ref(null);
const filterRef = ref(null);

onBeforeMount(() => {
    current_module.value = getActiveModule("/admin/testimony");
    const permissions = current_module.value.permissions.map((p) => p.name);
    const modelName = current_module.value.model.toLowerCase();
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);
});

onMounted(() => {
    visibleColumns.value = columns.value
        .filter((c) => c.type !== "hidden" && !c.required)
        .map((c) => c.field);
});

const onRefreshData = (prop, data) => {
    pagination.value[prop] = data !== undefined && data !== null ? data : null;
    pagination.value.page = 1;
    onRequest();
};

const onClear = () => {
    pagination.value.page = 1;
    pagination.value.sortBy = null;
    pagination.value.filters = null;
    pagination.value.search = null;
    onRequest();
};

const onRequest = async (attrs) => {
    const { page, rowsPerPage, descending, sortBy, search, filters } = attrs
        ? attrs.pagination
        : pagination.value;
    const sortDirection = descending ? "DESC" : "ASC";
    const params = {
        page,
        rowsPerPage,
        search,
        filters,
        sortBy,
        sortDirection,
    };
    loading.value = true;
    axios
        .post(`/admin/users/testimonies/${props.user.id}`, params)
        .then((res) => {
            const data = res.data;
            rows.value = data.rows;
            pagination.value.rowsNumber = data.total;
            pagination.value.rowsPerPage = rowsPerPage;
            pagination.value.page = data.page;
            pagination.value.sortBy = sortBy;
            pagination.value.descending = sortDirection === "DESC";

            usePage().props.search =
                search !== null && search !== undefined ? search : null;

            usePage().props.filters =
                filters !== null && filters !== undefined ? filters : null;
        })
        .finally(() => {
            loading.value = false;
        });
};

const openImage = (url) => {
    openURL(url, undefined);
};

const onPublicated = (id) => {
    Loading.show();
    axios
        .post(`/admin/testimony/publicated/${id}`)
        .then((res) => {
            let data = res.data;
            success(data.message);
            onRequest();
        })
        .finally(() => {
            Loading.hide();
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

#items {
    padding: 0;
}

#items > li {
    padding: 10px;
    list-style: none;
    cursor: pointer;
}

#items > li:hover {
    background-color: #cdcdcd;
}
</style>
