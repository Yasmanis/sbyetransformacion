<template>
    <q-table
        class="q-mx-sm"
        row-key="id"
        flat
        color="primary"
        :rows="visibleRows"
        :columns="columns"
        :pagination="{ rowsPerPage: 0 }"
        :loading="loading"
        binary-state-sort
    >
        <template v-slot:top>
            <q-toolbar>
                <section
                    class="q-my-xs q-mr-sm cursor-pointer text-subtitle1"
                    v-if="hasTitle"
                >
                    <div class="doc-card-title bg-primary text-white">
                        <q-icon name="mdi-file-account-outline" size="22px" />
                        mis documentos
                    </div>
                </section>
                <q-input
                    v-model="filterText"
                    dense
                    placeholder="buscar archivos..."
                    class="col"
                    style="max-width: 300px"
                >
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
                <q-space />
                <btn-add-component @click="handleAdd(null)" />
                <btn-reload-component @click="router.reload()" />
                <q-btn-component
                    icon="mdi-expand-all-outline"
                    tooltips="expandir todo"
                    @click="expandAll"
                />
                <q-btn-component
                    icon="mdi-collapse-all-outline"
                    tooltips="contraer todo"
                    @click="collapseAll"
                />
            </q-toolbar>
        </template>
        <template v-slot:header="props">
            <q-tr :props="props">
                <q-th
                    v-for="col in props.cols"
                    :key="col.name"
                    :props="props"
                    @click="handleSort(col.name)"
                    class="cursor-pointer"
                >
                    {{ col.label }}
                    <q-icon
                        v-if="sortBy === col.name"
                        :name="
                            sortOrder === 'asc'
                                ? 'arrow_upward'
                                : 'arrow_downward'
                        "
                        size="xs"
                    />
                </q-th>
            </q-tr>
        </template>

        <template v-slot:body="props">
            <q-tr
                :props="props"
                draggable="true"
                @dragstart="onDragStart($event, props.row)"
                @dragover="onDragOver($event, props.row)"
                @drop="onDrop($event, props.row)"
                @dragleave="
                    isDraggingOver = null;
                    dropPosition = null;
                "
                :class="{
                    'target-folder-active':
                        isDraggingOver === props.row.id &&
                        dropPosition === 'inside',
                    'drop-before':
                        isDraggingOver === props.row.id &&
                        dropPosition === 'before',
                    'drop-after':
                        isDraggingOver === props.row.id &&
                        dropPosition === 'after',
                }"
            >
                <q-td
                    key="name"
                    :props="props"
                    @click.stop="toggleExpand(props.row)"
                >
                    <div
                        class="row items-center no-wrap"
                        :style="{
                            paddingLeft: !filterText
                                ? props.row.level * 20 + 'px'
                                : null,
                        }"
                    >
                        <div style="width: 30px">
                            <q-btn
                                flat
                                round
                                dense
                                :icon="
                                    props.row.expanded
                                        ? 'keyboard_arrow_down'
                                        : 'keyboard_arrow_right'
                                "
                                size="sm"
                                v-if="props.row.is_folder"
                            />
                        </div>
                        <q-icon
                            :name="
                                props.row.is_folder
                                    ? 'folder'
                                    : 'insert_drive_file'
                            "
                            :color="
                                props.row.is_folder ? 'orange' : 'blue-grey'
                            "
                            class="q-mr-sm"
                        />
                        <span
                            class="cursor-pointer"
                            v-if="props.row.is_folder"
                            >{{ props.row.name }}</span
                        >
                        <span v-else>{{ props.row.name }}</span>
                    </div>
                </q-td>

                <q-td key="size" :props="props">{{
                    props.row.size
                        ? format.humanStorageSize(props.row.size, 2)
                        : "--"
                }}</q-td>
                <q-td key="updated_at" :props="props">{{
                    date.formatDate(props.row.updated_at, "DD/MM/YYYY hh:mm A")
                }}</q-td>
                <q-td key="actions" :props="props">
                    <btn-add-component
                        :disable="
                            !props.row.is_folder ||
                            props.row.permission !== 'owner'
                        "
                        @click="handleAdd(props.row)"
                    />
                    <btn-edit-component
                        :disable="props.row.permission !== 'owner'"
                        @click="handleEdit(props.row)"
                    />
                    <!-- <select-users
                        name="shareds"
                        icon="mdi-share-variant-outline"
                        :attach-to="props.row"
                        :disable="props.row.permission !== 'owner'"
                        :model-value="props.row.users"
                        @update="onSelectUsers"
                    /> -->
                    <btn-show-hide-component
                        :public="false"
                        :disable="props.row.is_folder"
                        @click="openFile(props.row.id)"
                    />
                    <btn-download-component
                        size="11px"
                        :disable="props.row.is_folder"
                        @click="downloadFile(props.row.id)"
                    />
                    <delete-component
                        :objects="[props.row]"
                        :disable="props.row.permission !== 'owner'"
                        url="/admin/documents"
                        size="sm"
                    />
                </q-td>
            </q-tr>
        </template>
    </q-table>
    <form-component
        :user="user"
        :parent="parent"
        :object="currentObject"
        :show="showDialog"
        @hide="
            () => {
                showDialog = false;
                currentObject = null;
                parent = null;
            }
        "
    />
</template>

<script setup>
import { ref, computed } from "vue";
import { format, useQuasar, date } from "quasar";
import QBtnComponent from "../../base/QBtnComponent.vue";
import FormComponent from "./FormComponent.vue";
import BtnReloadComponent from "../../btn/BtnReloadComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import BtnShowHideComponent from "../../btn/BtnShowHideComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import { router, useForm } from "@inertiajs/vue3";
import SelectUsers from "../../form/input/SelectUsers.vue";

const props = defineProps({
    user: Object,
    hasTitle: Boolean,
    documents: {
        type: Array,
        default: [],
    },
});

const $q = useQuasar();
const filterText = ref("");
const expandedIds = ref([]);
const isDraggingOver = ref(null);
const sortBy = ref("name");
const sortOrder = ref("asc");
const loading = ref(false);
const parent = ref(null);
const currentObject = ref(null);
const showDialog = ref(false);

const columns = [
    {
        name: "name",
        label: "nombre",
        align: "left",
    },
    {
        name: "size",
        label: "tamaño",
        align: "left",
    },
    {
        name: "updated_at",
        label: "modificado",
        align: "left",
    },
    {
        name: "actions",
        label: "",
        align: "right",
    },
];

const handleSort = (colName) => {
    if (sortBy.value !== colName) {
        sortBy.value = colName;
        sortOrder.value = "asc";
    } else if (sortOrder.value === "asc") {
        sortOrder.value = "desc";
    } else {
        sortBy.value = null;
        sortOrder.value = null;
    }
};

const visibleRows = computed(() => {
    const result = [];
    const presentIds = new Set(props.documents.map((d) => d.id));
    const processItems = (parentId, level) => {
        let children = props.documents.filter(
            (item) => item.parent_id === parentId
        );

        children.sort((a, b) => {
            if (a.is_folder !== b.is_folder) {
                return b.is_folder - a.is_folder;
            }
            if (!sortBy.value) {
                return (a.sort_order || 0) - (b.sort_order || 0);
            } else {
                const field = sortBy.value;
                const factor = sortOrder.value === "asc" ? 1 : -1;
                if (a[field] < b[field]) return -1 * factor;
                if (a[field] > b[field]) return 1 * factor;
                return 0;
            }
        });

        children.forEach((child) => {
            const matchesFilter = child.name
                .toLowerCase()
                .includes(filterText.value.toLowerCase());
            const isExpanded = expandedIds.value.includes(child.id);

            if (!filterText.value || matchesFilter) {
                result.push({ ...child, level, expanded: isExpanded });
            }

            if (child.is_folder && (isExpanded || filterText.value)) {
                processItems(child.id, level + 1);
            }
        });
    };
    const rootElements = props.documents.filter(
        (item) => item.parent_id === null || !presentIds.has(item.parent_id)
    );
    const rootParentIds = [...new Set(rootElements.map((el) => el.parent_id))];

    rootParentIds.forEach((pId) => {
        processItems(pId, 0);
    });

    return result;
});

const draggedItem = ref(null);

const dropPosition = ref(null);

const isDescendant = (targetId, draggedId) => {
    let current = props.documents.find((d) => d.id === targetId);
    while (current && current.parent_id) {
        if (current.parent_id === draggedId) return true;
        current = props.documents.find((d) => d.id === current.parent_id);
    }
    return false;
};

const hasAccessByShared = (targetId, draggedId) => {
    let target = props.documents.find((d) => d.id === targetId),
        dragged = props.documents.find((d) => d.id === draggedId);
    if (target?.permission !== "owner" || dragged?.permission !== "owner") {
        return true;
    }
    return false;
};

const onDragStart = (event, row) => {
    draggedItem.value = row;
    event.dataTransfer.setData("itemId", row.id);
    event.dataTransfer.dropEffect = "move";
};

const onDragOver = (event, targetRow) => {
    const draggedId = draggedItem.value?.id;
    if (
        !draggedId ||
        targetRow.id === draggedId ||
        isDescendant(targetRow.id, draggedId) ||
        hasAccessByShared(targetRow.id, draggedId)
    ) {
        event.dataTransfer.dropEffect = "none";
        isDraggingOver.value = null;
        dropPosition.value = null;
        return;
    }

    event.preventDefault();
    event.dataTransfer.dropEffect = "move";

    const rect = event.currentTarget.getBoundingClientRect();
    const y = event.clientY - rect.top;
    const threshold = rect.height / 4;

    if (y < threshold) {
        dropPosition.value = "before";
        isDraggingOver.value = targetRow.id;
    } else if (y > rect.height - threshold) {
        dropPosition.value = "after";
        isDraggingOver.value = targetRow.id;
    } else if (targetRow.is_folder) {
        dropPosition.value = "inside";
        isDraggingOver.value = targetRow.id;
    } else {
        dropPosition.value = y < rect.height / 2 ? "before" : "after";
        isDraggingOver.value = targetRow.id;
    }
};

const onDrop = (event, targetRow) => {
    const draggedId = parseInt(event.dataTransfer.getData("itemId"));
    const dragged = props.documents.find((i) => i.id === draggedId);
    const position = dropPosition.value;

    isDraggingOver.value = null;
    dropPosition.value = null;

    if (!dragged || !position || targetRow.id === dragged.id) return;

    let newParentId = dragged.parent_id;

    if (position === "inside") {
        newParentId = targetRow.id;
    } else {
        newParentId = targetRow.parent_id;
    }

    useForm({
        parent_id: newParentId,
        target_id: targetRow.id,
        drop_position: position,
    }).post(`/admin/documents/move/${dragged.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            if (
                position === "inside" &&
                !expandedIds.value.includes(targetRow.id)
            ) {
                expandedIds.value.push(targetRow.id);
            }
        },
    });
    draggedItem.value = null;
};

const toggleExpand = (row) => {
    if (row.is_folder) {
        const idx = expandedIds.value.indexOf(row.id);
        idx > -1
            ? expandedIds.value.splice(idx, 1)
            : expandedIds.value.push(row.id);
    }
};

const expandAll = () =>
    (expandedIds.value = props.documents
        .filter((i) => i.is_folder)
        .map((i) => i.id));
const collapseAll = () => (expandedIds.value = []);

const handleAdd = (p = null) => {
    parent.value = p;
    showDialog.value = true;
};

const handleEdit = (p = null) => {
    currentObject.value = p;
    showDialog.value = true;
};

const downloadFile = (id) => {
    window.location.href = route("documents.download", id);
};

const openFile = (id) => {
    window.open(route("documents.open", id), "_blank");
};

const onSelectUsers = (name, val, attach) => {
    useForm({
        users: val,
    }).post(`/admin/documents/shared/${attach.id}`);
};
</script>
<style>
.target-folder-active {
    background-color: #e3f2fd !important;
    outline: 2px dashed #2196f3;
    outline-offset: -4px;
}

.drop-before td {
    box-shadow: inset 0 2px 0 0 #2196f3 !important;
}

.drop-after td {
    box-shadow: inset 0 -2px 0 0 #2196f3 !important;
}

[draggable="true"] {
    cursor: grab;
}
[draggable="true"]:active {
    cursor: grabbing;
}

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
