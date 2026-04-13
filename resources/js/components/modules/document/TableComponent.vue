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
                <form-component :user="user" @reload-data="loadData" />
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
                :class="{
                    'target-folder-active': isDraggingOver === props.row.id,
                }"
                @dragenter="isDraggingOver = props.row.id"
                @dragleave="isDraggingOver = null"
            >
                <q-td key="name" :props="props">
                    <div
                        class="row items-center no-wrap"
                        :style="{
                            paddingLeft: props.row.level * 20 + 'px',
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
                                @click.stop="toggleExpand(props.row)"
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
                            @click="toggleExpand(props.row)"
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
            </q-tr>
        </template>
    </q-table>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { format, useQuasar, date } from "quasar";
import QBtnComponent from "../../base/QBtnComponent.vue";
import FormComponent from "./FormComponent.vue";
import axios from "axios";

const props = defineProps({
    user: Object,
    url: {
        type: String,
        default: "/admin/documents/index",
    },
});

const $q = useQuasar();
const filterText = ref("");
const expandedIds = ref([]);
const isDraggingOver = ref(null);
const sortBy = ref("name");
const sortOrder = ref("asc");
const loading = ref(false);
const rows = ref([]);

onMounted(() => {
    loadData();
});

const loadData = async () => {
    loading.value = true;
    const data = await axios
        .post(`${props.url}/${props.user.id}`)
        .then((res) => {
            rows.value = res.data;
        })
        .catch((e) => {
            console.log(e);
        });
    loading.value = false;
};

const columns = [
    { name: "name", label: "nombre", align: "left" },
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
];

const handleSort = (colName) => {
    if (sortBy.value === colName) {
        sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
    } else {
        sortBy.value = colName;
        sortOrder.value = "asc";
    }
};

const visibleRows = computed(() => {
    const result = [];

    const processItems = (parentId, level) => {
        let children = rows.value.filter((item) => item.parent_id === parentId);

        children.sort((a, b) => {
            let valA = a[sortBy.value] || "";
            let valB = b[sortBy.value] || "";
            return sortOrder.value === "asc"
                ? valA.localeCompare(valB)
                : valB.localeCompare(valA);
        });

        children.forEach((child) => {
            const matchesFilter = child.name
                .toLowerCase()
                .includes(filterText.value.toLowerCase());

            if (filterText.value && matchesFilter && child.parent_id) {
                if (!expandedIds.value.includes(child.parent_id))
                    expandedIds.value.push(child.parent_id);
            }

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

const onDragStart = (event, row) => {
    draggedItem.value = row;
    event.dataTransfer.setData("itemId", row.id);
    event.dataTransfer.dropEffect = "move";
};

const onDragOver = (event, targetRow) => {
    const isValidTarget =
        targetRow.is_folder &&
        targetRow.id !== draggedItem.value.id &&
        targetRow.id !== draggedItem.value.parent_id;

    if (isValidTarget) {
        event.preventDefault();
        isDraggingOver.value = targetRow.id;
    } else {
        isDraggingOver.value = null;
    }
};

const onDrop = (event, targetRow) => {
    isDraggingOver.value = null;
    const draggedId = parseInt(event.dataTransfer.getData("itemId"));

    const item = rows.value.find((i) => i.id === draggedId);
    if (item) {
        item.parent_id = targetRow.id;
        $q.notify({
            message: `Movido con éxito a ${targetRow.name}`,
            color: "positive",
            icon: "check",
        });
    }
    draggedItem.value = null;
};

const toggleExpand = (row) => {
    const idx = expandedIds.value.indexOf(row.id);
    idx > -1
        ? expandedIds.value.splice(idx, 1)
        : expandedIds.value.push(row.id);
};

const expandAll = () =>
    (expandedIds.value = rows.value
        .filter((i) => i.is_folder)
        .map((i) => i.id));
const collapseAll = () => (expandedIds.value = []);
</script>
<style scoped>
.target-folder-active {
    background-color: #e3f2fd !important;
    outline: 2px dashed #2196f3;
    outline-offset: -4px;
}

[draggable="true"] {
    cursor: grab;
}
[draggable="true"]:active {
    cursor: grabbing;
}
</style>
