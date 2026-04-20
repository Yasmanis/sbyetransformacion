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
            <q-toolbar class="q-pa-none">
                <section>
                    <q-input
                        v-model="filterText"
                        dense
                        placeholder="buscar archivos..."
                        class="col"
                    >
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </section>
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
                        :disable="!props.row.is_folder"
                        @click="handleAdd(props.row)"
                    />
                    <btn-edit-component
                        @click="handleEdit(props.row)"
                    /><btn-show-hide-component
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
import { ref, computed, onMounted } from "vue";
import { format, useQuasar, date, Dialog } from "quasar";
import QBtnComponent from "../../base/QBtnComponent.vue";
import FormComponent from "./FormComponent.vue";
import FormBody from "./FormBody.vue";
import BtnReloadComponent from "../../btn/BtnReloadComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnDownloadComponent from "../../btn/BtnDownloadComponent.vue";
import BtnShowHideComponent from "../../btn/BtnShowHideComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import axios from "axios";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
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
    { name: "name", label: "nombre", align: "left", sort: false },
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

    const processItems = (parentId, level) => {
        let children = props.documents.filter(
            (item) => item.parent_id === parentId,
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

    processItems(null, 0);
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

const onDragStart = (event, row) => {
    draggedItem.value = row;
    event.dataTransfer.setData("itemId", row.id);
    event.dataTransfer.dropEffect = "move";
};

const onDragOver = (event, targetRow) => {
    const draggedId = draggedItem.value?.id;
    if (!draggedId || targetRow.id === draggedId) {
        event.dataTransfer.dropEffect = "none";
        isDraggingOver.value = null;
        dropPosition.value = null;
        return;
    }

    if (isDescendant(targetRow.id, draggedId)) {
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
</script>
<style scoped>
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
</style>
